// Modern
jQuery(document).ready(function($) {
    var $example = $(".example--bars"),
		$ceDays = $example.find('.ce-days'),
		$ceHours = $example.find('.ce-hours'),
		$ceMinutes = $example.find('.ce-minutes'),
		$ceSeconds = $example.find('.ce-seconds'),
		$daysFill = $('.ce-bar-days').find('.ce-fill'),
		$hoursFill = $('.ce-bar-hours').find('.ce-fill'),
		$minutesFill = $('.ce-bar-minutes').find('.ce-fill'),
		$secondsFill = $('.ce-bar-seconds').find('.ce-fill'),
		now = new Date(),
		then = new Date(now.getTime() + (14 * 24*60*60*1000));
		
		var counter_vars=setCounterVariables();
		
	$example.find(".ce-countdown").countEverest({
		day: counter_vars[0],
		month: counter_vars[1],
		year: counter_vars[2],
		singularLabels: false,
		daysLabel: counter_vars[3],
		dayLabel: counter_vars[4],
		hoursLabel: counter_vars[5],
		hourLabel: counter_vars[6],
		minutesLabel: counter_vars[7],
		minuteLabel: counter_vars[8],
		secondsLabel: counter_vars[9],
		secondLabel: counter_vars[10],
		onChange: function() {
			setBar($daysFill, this.days, 365);
			setBar($hoursFill, this.hours, 24);
			setBar($minutesFill, this.minutes, 60);
			setBar($secondsFill, this.seconds, 60);
		}
	});

	function setBar($el, value, max) {
		barWidth = 100 -(100/max * value);
		$el.width( barWidth + '%' );
	}
});

