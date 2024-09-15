<!DOCTYPE html>
<html>
  <head>
    <title>Reports</title>
    <link rel="stylesheet" type="text/css" href="css/reports.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="js/jquery-2.2.3.min.js"></script>
    <script src="js/reports.js"></script>
    <script>
      $(document).ready(function() {
        function loadTable() {
          var date1 = $("#date1").val();
          var date2 = $("#date2").val();

          $.ajax({
            url: "reportslog_up.php",
            type: 'POST',
            data: {
              'date1': date1,
              'date2': date2,
              'log_date': true
            },
            success: function(data) {
              $('#reports').html(data);
            }
          });
        }

        $("#reports").click(function() {
          loadTable();
        });

        loadTable();

        
      });

      // Function to hide the selection
      function hideDataSelection() {
        var dateSection = document.getElementById('datesearch');
        dateSection.classList.add('hidden');
      }
      function hidenameSelection() {
        var nameSection = document.getElementById('namesearch');
        nameSection.classList.add('hidden');
      }
      function hiderollSelection() {
        var rollSection = document.getElementById('rollsearch');
        rollSection.classList.add('hidden');
      }
      function hideidSelection() {
        var idSection = document.getElementById('idsearch');
        idSection.classList.add('hidden');
      }

      // Function to show the selection
      function showDateSelection() {
        var dateSection = document.getElementById('datesearch');
        dateSection.classList.remove('hidden');
      }

      function shownamesearch() {
        var nameSection = document.getElementById('namesearch');
        nameSection.classList.remove('hidden');
      }

      function showrollsearch() {
        var rollSection = document.getElementById('rollsearch');
        rollSection.classList.remove('hidden');
      }

      function showidsearch() {
        var idSection = document.getElementById('idsearch');
        idSection.classList.remove('hidden');
      }

      // Event listener for radio button change
      document.addEventListener('change', function(event) {
        var selectedOption = event.target.id;
        switch (selectedOption) {
          case 'date':
            showDateSelection();
            hideidSelection();
            hidenameSelection();
            hiderollSelection();
            break;
          case 'id':
            showidsearch();
            hidenameSelection();
            hiderollSelection();
            hideDataSelection();
            break;
          case 'roll':
            showrollsearch();
            hidenameSelection();
            hideidSelection();
            hideDataSelection();
            break;
          case 'name':
            shownamesearch();
            hiderollSelection();
            hideidSelection();
            hideDataSelection();
            break;
          
        }
      });
    </script>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <main>
      <section>
        <h1 class="slideInDown animated">Reports</h1>
        <div class="radio slideInDown animated">
          <input type="radio" name="select" value="date" id="date" >
          <label for="date">Date</label>
          
          <input type="radio" name="select" value="name" id="name" >
          <label for="name">Name</label>
          <input type="radio" name="select" value="roll" id="roll" >
          <label for="roll">Roll Number</label> 
        </div>

        <div class="name_selection slideInDown animated hidden" id="namesearch">
          <form method="POST" action="exporttoexcel.php">
            <input type="text" name="namesearch" id="namesearch-input" placeholder="Enter name...">
            <button type="button" name="user_log" id="namesearch-btn">Submit</button>
            <input type="submit" name="Excel" value="Export to Excel">
          </form>
        </div>

        <div class="roll_selection slideInDown animated hidden" id="rollsearch">
          <form method="POST" action="exporttoexcel.php">
            <input type="text" name="rollsearch" id="rollsearch-input" placeholder="Enter roll no...">
            <button type="button" id="rollsearch-btn">Submit</button>
            <input type="submit" name="Excel" value="Export to Excel">
          </form>
        </div>

        <div class="id_selection slideInDown animated hidden" id="idsearch">
          <form method="POST" action="Export_Excel.php">
            <input type="text" name="idsearch" id="idsearch" placeholder="Enter id...">
            <button type="button" name="user_log" id="idsearch-btn">Submit</button>
            <input type="submit" name="To_Excel" value="Export to Excel">
          </form>
        </div>

        <div class="date_selection slideInDown animated hidden" id="datesearch">
          <form method="POST" action="exporttoexcel.php">
            <input type="date" name="date1" id="date1">
            <input type="date" name="date2" id="date2">
            <button type="button" id="datesearch-btn">Submit</button>
            <input type="submit" name="Excel" value="Export to Excel" id="datesearch-excel-btn">
          </form>
        </div>

        <div class="tbl-header slideInRight animated">
          <table cellpadding="0" cellspacing="0" border="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Roll Number</th>
                <th>Fingerprint ID</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
              </tr>
            </thead>
          </table>
        </div>

        <div class="tbl-content slideInRight animated">
          <div id="reports"></div>
        </div>
      </section>
    </main>
  </body>
</html>
