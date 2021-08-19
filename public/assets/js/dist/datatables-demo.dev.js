"use strict";

// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').dataTable({
    //Scroll infinito 
    "paging": false,
    "fnInitComplete": function fnInitComplete() {
      var myCustomScrollbar = document.querySelector('#dt-vertical-scroll_wrapper .dataTables_scrollBody');
      var ps = new PerfectScrollbar(myCustomScrollbar);
    },
    "scrollY": 450,
    "ajax": "roles/ajax.txt",
    "columns": [{
      "data": "name"
    }, {
      "data": "position"
    }, {
      "data": "office"
    }, {
      "data": "extn"
    }, {
      "data": "start_date"
    }, {
      "data": "salary"
    }] // select: {
    //     style: 'os',
    //     items: 'cell'
    // }

  });
});