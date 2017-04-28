<?php defined('SYSPATH') or die('No direct script access.') ?>

<style type="text/css">
<?php include Kohana::find_file('views', 'profiler/style', 'css') ?>
</style>

<?php
$group_stats = Profiler::group_stats();
$group_cols = array( 'min', 'max', 'average', 'total' );
$application_cols = array( 'min', 'max', 'average', 'current' );
?>

<div class="">
	<?php foreach( Profiler::groups() as $group => $benchmarks ): ?>
		<table class="" border="1">
			<tr class="">
				<th class="" rowspan="2"><?php echo __(ucfirst($group)) ?></th>
				<td class="" colspan="4"><?php echo number_format($group_stats[$group]['total']['time'], 6) ?> <abbr title="seconds">s</abbr></td>
			</tr>
			<tr class="">
				<td class="" colspan="4"><?php echo number_format($group_stats[$group]['total']['memory'] / 1024, 4) ?> <abbr title="kilobyte">kB</abbr></td>
			</tr>
			<tr class="">
				<th class=""><?php echo __('Benchmark').' - '.count($benchmarks) ?></th>
				<?php foreach( $group_cols as $key ): ?>
					<th class="<?php echo $key ?>"><?php echo __(ucfirst($key)) ?></th>
				<?php endforeach ?>
			</tr>
			<?php foreach( $benchmarks as $name => $tokens ): ?>
				<tr class="">
					<?php $stats = Profiler::stats($tokens) ?>
					<th class="" rowspan="2" scope="rowgroup"><?php echo $name, ' (', count($tokens), ')'; ?></th>
					<?php foreach( $group_cols as $key ): ?>
						<td class="<?php echo $key ?>">
							<div>
								<div class=""><?php echo number_format($stats[$key]['time'], 6) ?> <abbr title="seconds">s</abbr></div>
								<?php if($key === 'total'): ?>
									<div class="" style="left: <?php echo max(0, 100 - $stats[$key]['time'] / $group_stats[$group]['max']['time'] * 100) ?>%"></div>
								<?php endif ?>
							</div>
						</td>
					<?php endforeach ?>
				</tr>
				<tr class="">
					<?php foreach( $group_cols as $key ): ?>
						<td class="<?php echo $key ?>">
							<div>
								<div class=""><?php echo number_format($stats[$key]['memory'] / 1024, 4) ?> <abbr title="kilobyte">kB</abbr></div>
								<?php if($key === 'total'): ?>
									<div class="" style="left: <?php echo max(0, 100 - $stats[$key]['memory'] / $group_stats[$group]['max']['memory'] * 100) ?>%"></div>
								<?php endif ?>
							</div>
						</td>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
		</table>
	<?php endforeach ?>

	<table class="">
		<?php $stats = Profiler::application() ?>
		<tr class="">
			<th class="" rowspan="2" scope="rowgroup"><?php echo __('Application Execution').' ('.$stats['count'].')' ?></th>
			<?php foreach( $application_cols as $key ): ?>
				<td class=""><?php echo number_format($stats[$key]['time'], 6) ?> <abbr title="seconds">s</abbr></td>
			<?php endforeach ?>
		</tr>
		<tr class="">
			<?php foreach( $application_cols as $key ): ?>
				<td class=""><?php echo number_format($stats[$key]['memory'] / 1024, 4) ?> <abbr title="kilobyte">kB</abbr></td>
			<?php endforeach ?>
		</tr>
	</table>
</div>