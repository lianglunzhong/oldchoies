<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Admin_Ticket_statistics extends Controller_Admin_Ticket
{
	public function action_general()
	{
		if($_POST)
			$parameter="from=".$_POST["from"]."&&to=".$_POST["to"]."&&by=".$_POST["by"];
		else 	
			$parameter="from=".date("Y-m-d",strtotime("-1 week"))."&&to=".date("Y-m-d")."&&by=d";
		$content = View::factory('admin/ticket/statistics_general')
					->set("parameter",$parameter)
					->render();
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
	
	public function action_general_statistics()
	{
		define("ONE_DAY", 24 * 60 * 60);
		$preg="/^[0-9]{4}(\-|\/)[0-9]{1,2}(\\1)[0-9]{1,2}(|\s+[0-9]{1,2}(:[0-9]{1,2}){0,2})$/";
		$from=$_GET['from'];
		$to=$_GET['to'];
		$by=$_GET['by'];
		$type=$_GET['type'];
		if(!preg_match($preg,$from)||!preg_match($preg,$to))
		{
			echo "Wrong Time Format!";
			return false;
		}
		$from=strtotime($from);
		$to=strtotime($to);
		switch ($type) {
			case "lines":
				$lines=ticket::instance()->get_ticket_privileged_line();
				$data=$this->draw_table($lines,"Lines","line_id",$from,$to,$by);
				$datas[]=$data;
				//data for graph
				$graph_data=array();
				$graph_column=array();
				for($i=1;$i<count($data)-1;$i++)
				{
					$graph_data[]=$data[$i][1];
					$graph_column[]=$data[$i][0];
				}
			break;
			
			case "users":
				$arr_user=Ticket::instance()->get_user_names_by_privilege();
				$datas[]=$this->draw_table($arr_user,"Name","user_id",$from,$to,$by);
			break;
			
			case "topics":
				$topics=Ticket::instance()->get_ticket_topic();
				$arr_topic=array();
				foreach ($topics as $value)
					$arr_topic[$value['id']]=$value['topic'];
				$datas[]=$this->draw_table($arr_topic,"Topic","topic_id",$from,$to,$by);
			break;
			
			case "status":
				$status=Ticket::instance()->get_ticket_status();
				$arr_status=array();
				foreach ($status as $value)
					$arr_status['\''.$value['status'].'\'']=$value['status'];
				$datas[]=$this->draw_table($arr_status,"Status","status",$from,$to,$by);
			break;
			
			case "sites":
				$lines=ticket::instance()->get_ticket_privileged_line();
				$table=1;
				foreach ($lines as $key=>$value)
				{
					$orm_sites=orm::factory('ticket_site')
						->where('line_id','=',$key)
						->where('is_active','=','1')
						->find_all();
					$site_all=array();
					$sites=array();
					foreach ($orm_sites as $orm_site)
						$site_all[$orm_site->id]=$orm_site->domain;
					if(Session::instance()->get('ticket_role')=="Admin")
						$sites=$site_all;
					else
					{
						if (Session::instance()->get('ticket_role')=="Manager")
						{
							$privilege=orm::factory('ticket_privilege')
										->where('code','like',$key.'-%')
										->where('user_id','=',Session::instance()->get('user_id'))
										->find_all();
						}
						else
						{
							$privilege=orm::factory('ticket_defaultowner')
										->where('code','like',$key.'-%')
										->where('user_id','=',Session::instance()->get('user_id'))
										->find_all();
						}
						foreach ($privilege as $p)
						{
							$p=explode("-",$p->code);
							if($key==$p[0]&&isset($site_all[$p[1]]))
								$sites[$p[1]]=$site_all[$p[1]];
						}
					}
					$datas[$table]['header'][0]=$value;
					$datas[$table]['header'][1]="Total";
					$topics=Ticket::instance()->get_ticket_topic();
					$arr_topic=array();
					foreach ($topics as $topic)
						$arr_topic[$topic['id']]=$topic['topic'];
					$status=Ticket::instance()->get_ticket_status();
					$arr_status=array();
					foreach ($status as $s)
						$arr_status['\''.$s['status'].'\'']=$s['status'];
					foreach($arr_topic as $v)
						$datas[$table]['header'][]=$v;
					foreach($arr_status as $v)
						$datas[$table]['header'][]=$v;
					$row=1;
					foreach ($sites as $key=>$value)
					{
						$datas[$table][$row][0]=str_ireplace("www.", "", $value);
						$datas[$table][$row][1]=Ticket::instance()->general_statistic(array("site_id=".$key),$from,$to+ONE_DAY-1);
						foreach ($arr_topic as $k=>$v)
							$datas[$table][$row][]=Ticket::instance()->general_statistic(array("site_id=".$key,"topic_id=".$k),$from,$to+ONE_DAY-1);
						foreach ($arr_status as $k=>$v)	
							$datas[$table][$row][]=Ticket::instance()->general_statistic(array("site_id=".$key,"status=".$k),$from,$to+ONE_DAY-1);
						$row++;				
					}
					$datas[$table][$row][0]="Total";
					for($m=0;$m<count($datas[$table]['header'])-1;$m++)
					{
						for($n=0;$n<count($sites);$n++)
						{
							if(!isset($datas[$table][$row][$m+1]))
								$datas[$table][$row][$m+1]=0;
							$datas[$table][$row][$m+1]+=$datas[$table][$n+1][$m+1];
						}
					} 
					$table++;										
				}
			break;
			
			case "amount":
				$status=Ticket::instance()->get_ticket_status();
				$arr_status=array();
				$data['header'][0]="Name";
				$data['header'][1]="Total";
				foreach ($status as $s)
				{
					$data['header'][]=$s['status'];
					$arr_status['\''.$s['status'].'\'']=$s['status'];
				}
				$arr_user=Ticket::instance()->get_user_names_by_privilege();
				$row=1;
				foreach ($arr_user as $key=>$value)
				{
					$data[$row][0]=$value;
					$data[$row][1]=Ticket::instance()->general_statistic(array("user_id=".$key),$from,$to+ONE_DAY-1);
					foreach ($arr_status as $k=>$v)
					{
						$data[$row][]=Ticket::instance()->general_statistic(array("user_id=".$key,"status=".$k),$from,$to+ONE_DAY-1);
					}
					$row++;
				}
				$data[$row][0]="Total";
				for($m=0;$m<count($arr_status)+1;$m++)
				{
					for ($n=0;$n<count($arr_user);$n++)
					{
						if(!isset($data[$row][$m+1]))
							$data[$row][$m+1]=0;
						$data[$row][$m+1]+=$data[$n+1][$m+1];
					}					
				}
				$datas[]=$data;
			break;
			
			case "workload":
				$arr_user=Ticket::instance()->get_user_names_by_privilege();
				for($i=0;$i<4;$i++)
				{
					$data['header'][$i*2]="Name";
					$data['header'][$i*2+1]="Count";
				}
				$row=1;
				$column=0;
				//data for graph
				$graph_data=array();
				$graph_column=array();
				foreach($arr_user as $key=>$value)
				{
					if($column<4)
					{
						$data[$row][$column*2]=$value;
//						$sql="SELECT COUNT(*) as num FROM ticket_messages 
//						WHERE ticketID IN 
//						( SELECT ticketID FROM ticket_messages GROUP BY ticketID HAVING COUNT(*)>1) 
//						AND user_id=".$key." AND updated between ".$from." and ".($to+ONE_DAY-1);
						$sql="SELECT COUNT(*) AS num FROM ticket_messages WHERE user_id=".$key." AND updated BETWEEN ".$from." AND ".($to+ONE_DAY-1);
						$count=DB::query(DATABASE::SELECT,$sql)->execute();
						$data[$row][$column*2+1]=$count[0]['num'];
						//data for graph
						$graph_data[]=$count[0]['num'];
						$graph_column[]=$value;
						$column++;
					}
					else
					{ 
						$row++;
						$column=0;
					}
				}
				$datas[]=$data;
				//data for graph		
			break;
			
			default:
				echo "No definition!";exit;
		}
		if(isset($graph_data))
			echo '<script type="text/javascript">
						var graph_data='.str_ireplace('"', '', json_encode($graph_data)).';
						var graph_column='.json_encode($graph_column).';
				  </script>';		
		$content = View::factory('admin/ticket/statistics_general_table')
						->set("type",$type)
						->set("datas",$datas)
						->render();
	}
	
	/**
	 * 
	 * Helper to create data table for statistics
	 * @param $row_info array('line_id'=>'line_name') ...
	 * @param $row_name displayed colomn name 'Lines' ...
	 * @param $select_colomn 'line_id' ...
	 * @param $from
	 * @param $to
	 * @param $by
	 */	
	function draw_table(array $row_info,$row_name,$select_colomn,$from,$to,$by)
	{
		$data=array();
		if($by=='y')
		{
			$sub_year=date('Y',$to)-date('Y',$from)+1;
			//write table header
			$data['header'][0]=$row_name;
			$data['header'][1]="Total";
			for ($i=0;$i<$sub_year;$i++)
				$data['header'][]=date("Y", strtotime("+".$i." year",$from));
			//write table data
			$row=1;
			foreach($row_info as $key=>$value)
			{
				//echo date("D M j G:i:s T Y",$time1);exit();
				$data[$row][0]=$value;
				$data[$row][1]=Ticket::instance()->general_statistic(array($select_colomn."=".$key),mktime(0,0,0,1,1,date('Y',$from)),mktime(0,0,0,12,30,date('Y',$to))+ONE_DAY-1);
				for($n=0;$n<$sub_year;$n++)
				{
					$start_year=mktime(0,0,0,1,1,date('Y',$from)+$n);
					$end_year=mktime(0,0,0,12,30,date('Y',$from)+$n)+ONE_DAY-1;
					$data[$row][$n+2]=Ticket::instance()->general_statistic(array($select_colomn."=".$key),$start_year,$end_year);
				}
				$row++;
			}
			//write table footer
			$data[$row][0]="Total";
			for($m=0;$m<count($row_info);$m++)
			{
				if(!isset($data[$row][1]))
					$data[$row][1]=0;
				$data[$row][1]+=$data[$m+1][1];
			}
			for ($i=0;$i<$sub_year;$i++)
			{
				for($m=0;$m<count($row_info);$m++)
				{
					if(!isset($data[$row][$i+2]))
						$data[$row][$i+2]=0;
					$data[$row][$i+2]+=$data[$m+1][$i+2];
				}
			} 
		}
		if($by=='d')
		{
			$sub_day=($to-$from)/ONE_DAY+1;
			//write table header
			$data['header'][0]=$row_name;
			$data['header'][1]="Total";
			for ($i=0;$i<$sub_day;$i++)
				$data['header'][]=date("Y-m-d", strtotime("+".$i." day",$from));
			//write table data
			$row=1;
			foreach($row_info as $key=>$value)
			{
				//echo date("D M j G:i:s T Y",$time1);exit();
				$data[$row][0]=$value;
				$data[$row][1]=Ticket::instance()->general_statistic(array($select_colomn."=".$key),$from,$to+ONE_DAY-1);
				for($n=0;$n<$sub_day;$n++)
					$data[$row][$n+2]=Ticket::instance()->general_statistic(array($select_colomn."=".$key),strtotime("+".$n." day",$from),strtotime("+".$n." day",$from)+ONE_DAY-1);
				$row++;
			}
			//write table footer
			$data[$row][0]="Total";
			for($m=0;$m<count($row_info);$m++)
			{
				if(!isset($data[$row][1]))
					$data[$row][1]=0;
				$data[$row][1]+=$data[$m+1][1];
			}
			for ($i=0;$i<$sub_day;$i++)
			{
				for($m=0;$m<count($row_info);$m++)
				{
					if(!isset($data[$row][$i+2]))
						$data[$row][$i+2]=0;
					$data[$row][$i+2]+=$data[$m+1][$i+2];
				}
			} 
		}
		if($by=='m')
		{
			$time1 = mktime(0,0,0,date('m',$from),1,date('Y',$from));
			$time2 = mktime(0,0,0,date('m',$to),1,date('Y',$to));
			$mon1 = getdate($time1);
			$mon2 = getdate($time2);
			$sub_mon = $mon2["mon"]-$mon1["mon"]+1+($mon2["year"]-$mon1["year"])*12;
			//write table header
			$data['header'][0]=$row_name;
			$data['header'][1]="Total";
			for ($i=0;$i<$sub_mon;$i++)
				$data['header'][]=date("Y-m", strtotime("+".$i." month",$time1));
			//write table data
			$row=1;
			foreach($row_info as $key=>$value)
			{
				//echo date("D M j G:i:s T Y",$time1);exit();
				$data[$row][0]=$value;
				$data[$row][1]=Ticket::instance()->general_statistic(array($select_colomn."=".$key),$time1,mktime(23,59,59,date('m',$to),date("t",mktime(0,0,0,date('m',$to),1,date('Y',$to))),date('Y',$to)));
				for($n=0;$n<$sub_mon;$n++)
				{
					$start_month=strtotime("+".$n." month",$time1);
					$end_month=strtotime("+".($n+1)." month",$time1)-1;
					$data[$row][$n+2]=Ticket::instance()->general_statistic(array($select_colomn."=".$key),$start_month,$end_month);
				}
				$row++;
			}
			//write table footer
			$data[$row][0]="Total";
			for($m=0;$m<count($row_info);$m++)
			{
				if(!isset($data[$row][1]))
					$data[$row][1]=0;
				$data[$row][1]+=$data[$m+1][1];
			}
			for ($i=0;$i<$sub_mon;$i++)
			{
				for($m=0;$m<count($row_info);$m++)
				{
					if(!isset($data[$row][$i+2]))
						$data[$row][$i+2]=0;
					$data[$row][$i+2]+=$data[$m+1][$i+2];
				}
			} 
		}
		return $data;
	}
}

?>