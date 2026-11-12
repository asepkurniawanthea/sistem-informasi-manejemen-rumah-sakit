<?php if(isset($_GET['idx'])){
$idx = $_GET['idx'];
?>
<!DOCTYPE html>
  <html><head>
  <link rel="stylesheet" media="print" href="../style/radiologi_diagnosa_pdf.css" type="text/css">
  <script>
  function subst() {
      var vars = {};
      var query_strings_from_url = document.location.search.substring(1).split('&');
      for (var query_string in query_strings_from_url) {
          if (query_strings_from_url.hasOwnProperty(query_string)) {
              var temp_var = query_strings_from_url[query_string].split('=', 2);
              vars[temp_var[0]] = decodeURI(temp_var[1]);
          }
      }
      var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
      for (var css_class in css_selector_classes) {
          if (css_selector_classes.hasOwnProperty(css_class)) {
              var element = document.getElementsByClassName(css_selector_classes[css_class]);
              for (var j = 0; j < element.length; ++j) {
                  element[j].textContent = vars[css_selector_classes[css_class]];
              }
          }
      }
  }
  </script></head><body style="border:0; margin: 0;" onload="subst()">
  <table style="border-bottom: 1px solid black; width: 100%">
    <tr>
      <td style="text-align:left">
        RM.09.02.08.15.Rev.132.06.16
      </td>
	  <td style="text-align:right">
        Hal : <span class="page"></span>/<span class="topage">
      </td>
	</tr>	
    </tr>
  </table>
  </body></html>
<?php } ?>  