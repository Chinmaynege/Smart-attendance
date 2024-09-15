$(document).ready(function() {
  // Get Report date range
  $('#datesearch-btn').click(function() {
    var date1 = $("#date1").val();
    var date2 = $("#date2").val();

    $.ajax({
      url: 'reportslog_up.php',
      type: 'POST',
      data: {
        'date1': date1,
        'date2': date2,
        'log_date': true
      },
      success: function(response) {
        $('#reports').html(response);
      }
    });
  });

  // Get Roll search
  $('#rollsearch-btn').click(function() {
    var searchRollNumber = $("#rollsearch-input").val();

    $.ajax({
      url: 'reportslog_up.php',
      type: 'POST',
      data: {
        'search_type': 'roll',
        'roll_number': searchRollNumber
      },
      success: function(response) {
        $('#reports').html(response);
      }
    });
  });

  // Get Name search
  $('#namesearch-btn').click(function() {
    var searchName = $("#namesearch-input").val();

    $.ajax({
      url: 'reportslog_up.php',
      type: 'POST',
      data: {
        'search_type': 'name',
        'name': searchName
      },
      success: function(response) {
        $('#reports').html(response);
      }
    });
  });


  // Prevent automatic search
  $("#datesearch-excel-btn").click(function () {
    $("#datesearch").submit();
  });
});
