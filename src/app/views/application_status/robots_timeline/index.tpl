{**
 * Uses charting library by Vasco Asturiano [https://github.com/vasturiano]
 * [https://github.com/vasturiano/timelines-chart]
*}

<div id="timeline"></div>

<script>
var timelineData = {!$timeline_data};
var timelineElement = document.getElementById( "timeline" );

var chart = TimelinesChart()(timelineElement)
.rightMargin(300)
.zQualitative(true)
.width(1000)
.data(timelineData);

chart.segmentTooltipContent( function(d) {
return '<strong>' + d.labelVal + ' </strong>' + '<br>'
            + '<strong>From: </strong>' + d.data.timeRange[0] + '<br>'
            + '<strong>To: </strong>' + d.data.timeRange[1] + '<br>'
            + '<strong>Running time: </strong>' + d.data.runtime + '<br>';
} );
</script>

