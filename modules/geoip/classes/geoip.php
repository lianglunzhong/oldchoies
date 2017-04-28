<?php
/**
 * Driver of Geoip Moudle (Copy from Geoip)
 *
 * @package Driver
 * @author Nye
 * @copyright © 2010 Cofree Development Group
 */
/* -*- Mode: C; indent-tabs-mode: t; c-basic-offset: 2; tab-width: 2 -*- */
/* geoip.inc
 *
 * Copyright (C) 2007 MaxMind LLC
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

define("GEOIP_COUNTRY_BEGIN", 16776960);
define("GEOIP_STATE_BEGIN_REV0", 16700000);
define("GEOIP_STATE_BEGIN_REV1", 16000000);
define("GEOIP_STANDARD", 0);
define("GEOIP_MEMORY_CACHE", 1);
define("GEOIP_SHARED_MEMORY", 2);
define("STRUCTURE_INFO_MAX_SIZE", 20);
define("DATABASE_INFO_MAX_SIZE", 100);
define("GEOIP_COUNTRY_EDITION", 106);
define("GEOIP_PROXY_EDITION", 8);
define("GEOIP_ASNUM_EDITION", 9);
define("GEOIP_NETSPEED_EDITION", 10);
define("GEOIP_REGION_EDITION_REV0", 112);
define("GEOIP_REGION_EDITION_REV1", 3);
define("GEOIP_CITY_EDITION_REV0", 111);
define("GEOIP_CITY_EDITION_REV1", 2);
define("GEOIP_ORG_EDITION", 110);
define("GEOIP_ISP_EDITION", 4);
define("SEGMENT_RECORD_LENGTH", 3);
define("STANDARD_RECORD_LENGTH", 3);
define("ORG_RECORD_LENGTH", 4);
define("MAX_RECORD_LENGTH", 4);
define("MAX_ORG_RECORD_LENGTH", 300);
define("GEOIP_SHM_KEY", 0x4f415401);
define("US_OFFSET", 1);
define("CANADA_OFFSET", 677);
define("WORLD_OFFSET", 1353);
define("FIPS_RANGE", 360);
define("GEOIP_UNKNOWN_SPEED", 0);
define("GEOIP_DIALUP_SPEED", 1);
define("GEOIP_CABLEDSL_SPEED", 2);
define("GEOIP_CORPORATE_SPEED", 3);

class Geoip
{

	public static $instances;
	var $flags;
	var $filehandle;
	var $memory_buffer;
	var $databaseType;
	var $databaseSegments;
	var $record_length;
	var $shmid;
	var $GEOIP_COUNTRY_CODE_TO_NUMBER;
	var $GEOIP_COUNTRY_CODES;
	var $GEOIP_COUNTRY_CODES3;
	var $GEOIP_COUNTRY_NAMES;
	var $GEOIP_CONTINENT_CODES;

	/**
	 *
	 * @param   string   the name of the cache group to use [Optional]
	 * @return  Kohana_Cache
	 * @throws  Kohana_Cache_Exception
	 */
	public static function instance()
	{

		if(isset(Geoip::$instances))
		{
			// Return the current group if initiated already
			return Geoip::$instances;
		}

		Geoip::$instances = new Geoip(Kohana::Config('geoip'));
		// Return the instance
		return Geoip::$instances;
	}

	public function __construct($config)
	{

		$this->flags = GEOIP_STANDARD;
		$this->GEOIP_COUNTRY_CODE_TO_NUMBER = $config['GEOIP_COUNTRY_CODE_TO_NUMBER'];
		$this->GEOIP_COUNTRY_CODES = $config['GEOIP_COUNTRY_CODES'];
		$this->GEOIP_COUNTRY_CODES3 = $config['GEOIP_COUNTRY_CODES3'];
		$this->GEOIP_COUNTRY_NAMES = $config['GEOIP_COUNTRY_NAMES'];
		$this->GEOIP_CONTINENT_CODES = $config['GEOIP_CONTINENT_CODES'];
		if($this->flags & GEOIP_SHARED_MEMORY)
		{
			$this->shmid = @shmop_open(GEOIP_SHM_KEY, "a", 0, 0);
		}
		else
		{
			$this->filehandle = fopen($config['IPDATA'], "rb") or die("Can not open ".$config['IPDATA']."\n");
			if($this->flags & GEOIP_MEMORY_CACHE)
			{
				$s_array = fstat($this->filehandle);
				$this->memory_buffer = fread($this->filehandle, $s_array['size']);
			}
		}
		$this->_setup_segments();
	}

	function geoip_load_shared_mem($file)
	{
		$fp = fopen($file, "rb");
		if( ! $fp)
		{
			print "error opening $file: $php_errormsg\n";
			exit;
		}
		$s_array = fstat($fp);
		$size = $s_array['size'];
		if($shmid = @shmop_open(GEOIP_SHM_KEY, "w", 0, 0))
		{
			shmop_delete($shmid);
			shmop_close($shmid);
		}
		$shmid = shmop_open(GEOIP_SHM_KEY, "c", 0644, $size);
		shmop_write($shmid, fread($fp, $size), 0);
		shmop_close($shmid);
	}

	function _setup_segments()
	{
		$this->databaseType = GEOIP_COUNTRY_EDITION;
		$this->record_length = STANDARD_RECORD_LENGTH;
		if($this->flags & GEOIP_SHARED_MEMORY)
		{
			$offset = @shmop_size($this->shmid) - 3;
			for( $i = 0; $i < STRUCTURE_INFO_MAX_SIZE; $i ++  )
			{
				$delim = @shmop_read($this->shmid, $offset, 3);
				$offset += 3;
				if($delim == (chr(255).chr(255).chr(255)))
				{
					$this->databaseType = ord(@shmop_read($this->shmid, $offset, 1));
					$offset ++;

					if($this->databaseType == GEOIP_REGION_EDITION_REV0)
					{
						$this->databaseSegments = GEOIP_STATE_BEGIN_REV0;
					}
					else if($this->databaseType == GEOIP_REGION_EDITION_REV1)
					{
						$this->databaseSegments = GEOIP_STATE_BEGIN_REV1;
					}
					else if(($this->databaseType == GEOIP_CITY_EDITION_REV0) ||
						($this->databaseType == GEOIP_CITY_EDITION_REV1)
						|| ($this->databaseType == GEOIP_ORG_EDITION)
						|| ($this->databaseType == GEOIP_ISP_EDITION)
						|| ($this->databaseType == GEOIP_ASNUM_EDITION))
					{
						$this->databaseSegments = 0;
						$buf = @shmop_read($this->shmid, $offset, SEGMENT_RECORD_LENGTH);
						for( $j = 0; $j < SEGMENT_RECORD_LENGTH; $j ++  )
						{
							$this->databaseSegments += ( ord($buf[$j]) << ($j * 8));
						}
						if(($this->databaseType == GEOIP_ORG_EDITION) ||
							($this->databaseType == GEOIP_ISP_EDITION))
						{
							$this->record_length = ORG_RECORD_LENGTH;
						}
					}
					break;
				}
				else
				{
					$offset -= 4;
				}
			}
			if(($this->databaseType == GEOIP_COUNTRY_EDITION) ||
				($this->databaseType == GEOIP_PROXY_EDITION) ||
				($this->databaseType == GEOIP_NETSPEED_EDITION))
			{
				$this->databaseSegments = GEOIP_COUNTRY_BEGIN;
			}
		}
		else
		{
			$filepos = ftell($this->filehandle);
			fseek($this->filehandle, -3, SEEK_END);
			for( $i = 0; $i < STRUCTURE_INFO_MAX_SIZE; $i ++  )
			{
				$delim = fread($this->filehandle, 3);
				if($delim == (chr(255).chr(255).chr(255)))
				{
					$this->databaseType = ord(fread($this->filehandle, 1));
					if($this->databaseType == GEOIP_REGION_EDITION_REV0)
					{
						$this->databaseSegments = GEOIP_STATE_BEGIN_REV0;
					}
					else if($this->databaseType == GEOIP_REGION_EDITION_REV1)
					{
						$this->databaseSegments = GEOIP_STATE_BEGIN_REV1;
					}
					else if(($this->databaseType == GEOIP_CITY_EDITION_REV0) ||
						($this->databaseType == GEOIP_CITY_EDITION_REV1) ||
						($this->databaseType == GEOIP_ORG_EDITION) ||
						($this->databaseType == GEOIP_ISP_EDITION) ||
						($this->databaseType == GEOIP_ASNUM_EDITION))
					{
						$this->databaseSegments = 0;
						$buf = fread($this->filehandle, SEGMENT_RECORD_LENGTH);
						for( $j = 0; $j < SEGMENT_RECORD_LENGTH; $j ++  )
						{
							$this->databaseSegments += ( ord($buf[$j]) << ($j * 8));
						}
						if($this->databaseType == GEOIP_ORG_EDITION ||
							$this->databaseType == GEOIP_ISP_EDITION)
						{
							$this->record_length = ORG_RECORD_LENGTH;
						}
					}
					break;
				}
				else
				{
					fseek($this->filehandle, -4, SEEK_CUR);
				}
			}
			if(($this->databaseType == GEOIP_COUNTRY_EDITION) ||
				($this->databaseType == GEOIP_PROXY_EDITION) ||
				($this->databaseType == GEOIP_NETSPEED_EDITION))
			{
				$this->databaseSegments = GEOIP_COUNTRY_BEGIN;
			}
			fseek($this->filehandle, $filepos, SEEK_SET);
		}
		return $this;
	}

	function geoip_country_id_by_name($name)
	{
		$addr = gethostbyname($name);
		if( ! $addr || $addr == $name)
		{
			return false;
		}
		return geoip_country_id_by_addr($this, $addr);
	}

	function geoip_country_code_by_name($name)
	{
		$country_id = geoip_country_id_by_name($name);
		if($country_id !== false)
		{
			return $this->GEOIP_COUNTRY_CODES[$country_id];
		}
		return false;
	}

	function geoip_country_name_by_name($name)
	{
		$country_id = $this->geoip_country_id_by_name($name);
		if($country_id !== false)
		{
			return $this->GEOIP_COUNTRY_NAMES[$country_id];
		}
		return false;
	}

	function geoip_country_id_by_addr($addr)
	{
		$ipnum = ip2long($addr);
		return $this->_geoip_seek_country($ipnum) - GEOIP_COUNTRY_BEGIN;
	}

	function geoip_country_code_by_addr($addr)
	{
		if($this->databaseType == GEOIP_CITY_EDITION_REV1)
		{
			$record = $this->geoip_record_by_addr($addr);
			if($record !== false)
			{
				return $record->country_code;
			}
		}
		else
		{
			$country_id = $this->geoip_country_id_by_addr($addr);
			if($country_id !== false)
			{
				return $this->GEOIP_COUNTRY_CODES[$country_id];
			}
		}
		return false;
	}

	function geoip_country_name_by_addr($addr)
	{
		if($this->databaseType == GEOIP_CITY_EDITION_REV1)
		{
			$record = $this->geoip_record_by_addr($addr);
			return $record->country_name;
		}
		else
		{
			$country_id = $this->geoip_country_id_by_addr($addr);
			if($country_id !== false)
			{
				return $this->GEOIP_COUNTRY_NAMES[$country_id];
			}
		}
		return false;
	}

	function _geoip_seek_country($ipnum)
	{
		$offset = 0;
		for( $depth = 31; $depth >= 0;  -- $depth )
		{
			if($this->flags & GEOIP_MEMORY_CACHE)
			{
				$enc = mb_internal_encoding();
				mb_internal_encoding('ISO-8859-1');

				$buf = substr($this->memory_buffer,
						2 * $this->record_length * $offset,
						2 * $this->record_length);

				mb_internal_encoding($enc);
			}
			elseif($this->flags & GEOIP_SHARED_MEMORY)
			{
				$buf = @shmop_read($this->shmid,
						2 * $this->record_length * $offset,
						2 * $this->record_length);
			}
			else
			{
				fseek($this->filehandle, 2 * $this->record_length * $offset, SEEK_SET) == 0
					or die("fseek failed");
				$buf = fread($this->filehandle, 2 * $this->record_length);
			}
			$x = array( 0, 0 );
			for( $i = 0; $i < 2;  ++ $i )
			{
				for( $j = 0; $j < $this->record_length;  ++ $j )
				{
					$x[$i] += ord($buf[$this->record_length * $i + $j]) << ($j * 8);
				}
			}
			if($ipnum & (1 << $depth))
			{
				if($x[1] >= $this->databaseSegments)
				{
					return $x[1];
				}
				$offset = $x[1];
			}
			else
			{
				if($x[0] >= $this->databaseSegments)
				{
					return $x[0];
				}
				$offset = $x[0];
			}
		}
		trigger_error("error traversing database - perhaps it is corrupt?", E_USER_ERROR);
		return false;
	}

	function _get_org($ipnum)
	{
		$seek_org = $this->_geoip_seek_country($this, $ipnum);
		if($seek_org == $this->databaseSegments)
		{
			return NULL;
		}
		$record_pointer = $seek_org + (2 * $this->record_length - 1) * $this->databaseSegments;
		if($this->flags & GEOIP_SHARED_MEMORY)
		{
			$org_buf = @shmop_read($this->shmid, $record_pointer, MAX_ORG_RECORD_LENGTH);
		}
		else
		{
			fseek($this->filehandle, $record_pointer, SEEK_SET);
			$org_buf = fread($this->filehandle, MAX_ORG_RECORD_LENGTH);
		}
		$enc = mb_internal_encoding();
		mb_internal_encoding('ISO-8859-1');
		$org_buf = substr($org_buf, 0, strpos($org_buf, 0));
		mb_internal_encoding($enc);
		return $org_buf;
	}

	function geoip_org_by_addr($addr)
	{
		if($addr == NULL)
		{
			return 0;
		}
		$ipnum = ip2long($addr);
		return $this->_get_org($ipnum);
	}

	function _get_region($ipnum)
	{
		if($this->databaseType == GEOIP_REGION_EDITION_REV0)
		{
			$seek_region = $this->_geoip_seek_country($ipnum) - GEOIP_STATE_BEGIN_REV0;
			if($seek_region >= 1000)
			{
				$country_code = "US";
				$region = chr(($seek_region - 1000) / 26 + 65).chr(($seek_region - 1000) % 26 + 65);
			}
			else
			{
				$country_code = $this->GEOIP_COUNTRY_CODES[$seek_region];
				$region = "";
			}
			return array( $country_code, $region );
		}
		else if($this->databaseType == GEOIP_REGION_EDITION_REV1)
		{
			$seek_region = $this->_geoip_seek_country($ipnum) - GEOIP_STATE_BEGIN_REV1;
			if($seek_region < US_OFFSET)
			{
				$country_code = "";
				$region = "";
			}
			else if($seek_region < CANADA_OFFSET)
			{
				$country_code = "US";
				$region = chr(($seek_region - US_OFFSET) / 26 + 65).chr(($seek_region - US_OFFSET) % 26 + 65);
			}
			else if($seek_region < WORLD_OFFSET)
			{
				$country_code = "CA";
				$region = chr(($seek_region - CANADA_OFFSET) / 26 + 65).chr(($seek_region - CANADA_OFFSET) % 26 + 65);
			}
			else
			{
				$country_code = $this->GEOIP_COUNTRY_CODES[($seek_region - WORLD_OFFSET) / FIPS_RANGE];
				$region = "";
			}
			return array( $country_code, $region );
		}
	}

	function geoip_region_by_addr($addr)
	{
		if($addr == NULL)
		{
			return 0;
		}
		$ipnum = ip2long($addr);
		return $this->_get_region($ipnum);
	}

	function getdnsattributes($l, $ip)
	{
		$r = new Net_DNS_Resolver();
		$r->nameservers = array( "ws1.maxmind.com" );
		$p = $r->search($l.".".$ip.".s.maxmind.com", "TXT", "IN");
		$str = is_object($p->answer[0]) ? $p->answer[0]->string() : '';
		ereg("\"(.*)\"", $str, $regs);
		$str = $regs[1];
		return $str;
	}

	function __destruct()
	{
		if($this->flags & GEOIP_SHARED_MEMORY)
		{
			return true;
		}
		return fclose($this->filehandle);
	}

}

?>
