$(document).ready(function() {
			var d1 = [];
			for (var i = 0; i <= 11; i += 1)
				d1.push([i, 10]);

			var d2 = [];
			for (var i = 0; i <= 11; i += 1)
				d2.push([i, -(parseInt(Math.random() * 10))]);

						
			function plotWithOptionsbars() {
				var stack = 0, bars = true, lines = false, steps = false;
				$.plot($("#bargraph"), [d1,d2], {
					series: {
						stack: stack,
						lines: { show: lines, steps: steps },
						bars: { show: bars, barWidth: 0.6,align: "center" }
					},
					xaxis: {
						tickFormatter:actionFormatter
					}
				});
			}
			function actionFormatter(cellvalue) {
				return String(cellvalue)+"name";
			}
			plotWithOptionsbars(); 
});