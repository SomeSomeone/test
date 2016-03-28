<?php
function valid($name){
    return (isset($_POST[$name])&&$_POST[$name]!="");
}

if(valid('first_name')&&valid('second_name')){//валидация
    $files_string="";//для ссылок на файлы
    for ($i=count ($_FILES['file']['name']);$i>=0;$i--){//цикл загрузки всех файлов
        if (! $_FILES['file']['error'][$i]>0 && $_FILES['file']['error'][$i]!="") {
            $file_url = "files/" . time() . $_FILES['file']['name'][$i];
            move_uploaded_file($_FILES['file']['tmp_name'][$i], $file_url);
            $files_string .= '<a href="http://test.com/' . $file_url . '">' . $_FILES['file']['name'][$i] . '</a><br />';
        }
    }
    $to = 'nice.gl_orl@ukr.net'; //кому
    $subject = 'письмо с сайта от '.$_POST['first_name'].' '.$_POST['second_name'];//заголовок
    $message= '
                    <html>
                        <head>
                            <title>'.$subject.'</title>
                        </head>
                        <body>
                        '.$_POST['content'].'
                        <br/>
                         '.$files_string.'
                        </body>
                        
                        
                    </html>
                ';
    $headers  = "Content-type: text/html; charset=utf-8 \r\n"; //Кодировка письма
    $headers .= "From: Отправитель <from@example.com> \r\n"; //от кого
    $result=mail($to, $subject, $message, $headers); //Отправка письма
};
?>