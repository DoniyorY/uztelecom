function PrintElem(elem, title='Отчёт')
{
    var mywindow = window.open('', title, 'height=1000,width=1000');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    //mywindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head><body >');
    mywindow.document.write(`
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');

      body {
           font-family: 'Roboto Condensed', sans-serif;
font-size: 12px;
        }
        table{
        border-collapse: collapse;
        }
        table tr td {
            padding:5px 7px;
            border: 1px black solid;
/*border-collapse: collapse;*/
text-align: center;
        }
        th{padding:5px 7px;
            border: 1px black solid;}
        .pagination{
        display: none;
        }

</style>`);
    mywindow.document.write('<h2 style="text-align:center">'+ title +'</h2>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();

    return true;
}
