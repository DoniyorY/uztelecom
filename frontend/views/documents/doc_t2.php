<?php
$this->title = 'Типовая междуведомственная форма № Т-2';
list($lastname, $firstname, $patronymic) = explode(" ", $model->fullname);
?>
<style>
    .border_b {
        border-bottom: 1px solid black;
    }

    p {
        height: 25px;
    }

    .subTitle {
        margin: 0;
        font-size: 10px;
        text-align: center;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <button type="button" onclick="PrintDoc('print-doc-t2','<?= $this->title ?>')"
                        class="btn btn-primary w-100"><i class="bi bi-printer"></i> Распечатать <i
                            class="ri-printer-line"></i>
                </button>
            </div>
        </div>
        <div id="print-doc-t2">
            <div class="row" style="border: 1px solid black;">
                <div class="col-md-6 pt-5">
                    <p class="border_b text-center" style="margin: 0; font-size: 30px; height: 45px;">OOO SIM SALABIM</p>
                    <p class="subTitle">(Предприятие, организация)</p>
                </div>
                <div class="col-md-6 pt-5">
                    <table class="table table-bordered text-center" style="border-color: black;">
                        <thead style="border-color: black">
                        <th>М/Ж</th>
                        <th>Табельный номер</th>
                        <th>Алфавит</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?=$model->getDirectory($model->sex)?></td>
                            <td><?=$model->id?></td>
                            <td>А А В</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <h2 style="color: black; text-align: center; margin-top: 20px;">Личная карточка № _____</h2>
                <h2 style="color: black; text-align: center;">I. Общие сведения</h2>
                <div class="col-md-6 p-4" style="border-right: 1px solid black">
                    <p class="border_b">1. Фамилия: <?=$lastname?> </p>
                    <p class="border_b">Имя: <?=$firstname?></p>
                    <p class="border_b">Отчество: <?=$patronymic?></p>
                    <p class="border_b">2. Год рождения: <?=date('Y',$model->birthday)?></p>
                    <p class="border_b"><span>Месяц: </span> <?=date('m',$model->birthday)?> <span style="margin-left: 100px;">Число: <?=date('d',$model->birthday)?></span></p>
                    <p class="border_b">3. Место рождения: </p>
                    <p class="border_b"></p>
                    <p class="border_b">4. Национальность: <?=$model->getDirectory($model->nationality)?></p>
                    <p class="border_b">5. Образование: Неокоченное высшее</p>
                    <p class="border_b" style="margin-bottom: 0;">a) </p>
                    <p class="subTitle">(высшее, среднее-спец., средн. общее,
                        неполное среднее, начальное (сколько кл.))</p>
                    <p class="border_b" style="margin-bottom: 0;">б) </p>
                    <p class="subTitle">(название и дата окончания высшего или среднего специального учебного заведения)
                    </p>
                    <p class="border_b" style="margin-bottom: 0;">в) </p>
                    <p class="subTitle">
                        ( название и дата окончания колледжей и профессионально-технических учебных заведений)

                    </p>
                    <p class="border_b" style="margin: 0;">г) Вид обучения: <span
                                style="margin-left: 20px;"> Дневное </span></p>
                    <p class="subTitle">(дневное, вечернее, заочное)</p>
                    <p class="border_b">6. Специальность по диплому (свидетельству):</p>
                    <p class="border_b" style="margin: 0;"></p>
                    <p class="subTitle">(для окончивших высшее или среднее специальное учебное заведение)‎‎‎</p>
                    <p class="border_b">7. Квалификация по диплому (свидетельству)</p>
                    <p class="border_b">
                        Диплом / Свидетельство <span style="margin-left: 60px;">№ 123</span> <span
                                style="margin-left: 60px;">«</span> <span style="margin-left: 40px;"> »</span> ______________
                        <span>20__г</span>
                    </p>
                </div>
                <div class="col-md-6 p-4">
                    <p class="border_b" style="margin: 0;">
                        8.
                    </p>
                    <p class="subTitle">(основная профессия (должность))!</p>
                    <p class="border_b" style="margin: 0;"></p>
                    <p class="subTitle">(стаж работы по основной профессии (должности))</p>
                    <p class="border_b">9. Общий стаж работы</p>
                    <p class="border_b" style="margin: 0;">10. </p>
                    <p class="subTitle">(последнее место работы, профессия (должность), дата и причина увольнения)</p>
                    <p class="border_b"></p>
                    <p class="border_b" style="margin: 0;">11. Семейное положение: Холост</p>
                    <p class="subTitle">(состав семьи с указанием года рождения каждого члена семьи)</p>
                    <p class="border_b">12.</p>
                    <p class="border_b">13.</p>
                    <p class="border_b">14.</p>
                    <p class="border_b">15.</p>
                    <p class="border_b">16.</p>
                    <p class="border_b">17.</p>
                    <p class="border_b">18.</p>
                    <p class="border_b">19.</p>
                    <p class="border_b">20.</p>
                    <p class="border_b">21.</p>
                    <p class="border_b">22. Паспорт: серия № </p>
                    <p class="border_b">Кем выдан: </p>
                    <p class="border_b">Дата выдачи: </p>
                    <p class="border_b">23. Домашний адрес:</p>
                    <p class="border_b"></p>
                    <p class="border_b"></p>
                    <br>
                    <p class="border_b">Телефон: </p>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function PrintDoc(elem, title='Отчёт')
    {
        var mywindow = window.open('', title, 'height=1000,width=1000');

        mywindow.document.write('<html><head><title>' + document.title + '</title>');
        mywindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head><body >');
        mywindow.document.write(`
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');
.border_b {
        border-bottom: 1px solid black;
    }

    p {
        height: 25px;
    }

    .subTitle {
        margin: 0;
        font-size: 10px;
        text-align: center;
    }
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
</script>