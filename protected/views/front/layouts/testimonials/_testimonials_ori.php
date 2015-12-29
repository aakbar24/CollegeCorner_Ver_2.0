<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|    iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|ph    one|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|ph    one)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|    s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|    nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|d    a(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|w    a|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|    hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im    1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k    |l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef    |mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|1    0)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c)    )|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r60    0|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|s    har|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|1    8)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750    |veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g     |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
     $MOBILE_PHONE_ACCESS = 'Y';
else $MOBILE_PHONE_ACCESS = 'N';
?>

<hr><hr>

<blockquote>
    <p>My husband and I on graduation had major challenges finding employment opportunities. 
    	 Thanks to this unique website, we can now consider ourselves IT professionals with excellent 
    	 jobs -- the service is free and the network within the industry made  all the difference.</p>
       
         <?php 
             if ($MOBILE_PHONE_ACCESS=='N') {
                echo '<br>' .  
                     '<TABLE width="70%" align="center">' .
                     '<TR>' .
                     '<TD>' . 
                          CHtml::image(Yii::app()->getBaseUrl() . '/files/images/testimonials/Rulani.jpg') .
                     '</TD>' .
                     '<TD>' . 
                          CHtml::image(Yii::app()->getBaseUrl() . '/files/images/testimonials/Donell.jpg') .
                     '</TD>' .
                     '<TD align=left width="230 px">' .
                         'Rulani Chauke<br>Business Analyst<br>Scotiabank<br><br>' .
                         'Donell Chauke<br>Technical Analyst<br>Scotiabank' .
                     '</TD>' .
                     '</TR>' .
                     '</TABLE>';
             }
             else {
                  echo '<br>' .  
                       CHtml::image(Yii::app()->getBaseUrl() . '/files/images/testimonials/Rulani.jpg') .
	               '<br>Rulani Chauke<br>Business Analyst<br>Scotiabank<br>' .
                       '<br>' .
                       CHtml::image(Yii::app()->getBaseUrl() . '/files/images/testimonials/Donell.jpg') .
                       '<br>Donell Chauke<br>Technical Analyst<br>Scotiabank' .
                       '<br>';
             }
          ?>
</blockquote>

<hr><hr>

<blockquote>
    <p>I was exploring every avenue to start my career in IT and then a 
       breakthrough came with an Internship at Scotia Bank in which 
       Collegecornerstone provided the vita link. I am now almost done with 
       my internship. It was an excellent opportunity. I have explored 
       and learned a  lot and through this experience, I am confident 
       of my future.</p>

         <?php 
             if ($MOBILE_PHONE_ACCESS=='N') {
                 echo '<BR>' . 
                      '<TABLE width="50%" align="center">' .
                      '<TR>' .
                      '<TD>' . 
                          CHtml::image(Yii::app()->getBaseUrl() . '/files/images/testimonials/Anam.jpg') .
                      '</TD>' .
                      '<TD align=left width="230 px">' .
                          'Anam Basharat<br>Quality Assurance Analyst<br>Scotiabank' .
                      '</TD>' .
                      '</TR>' .
                      '</TABLE>';
              }
             else {
                  echo '<br>' .
                       CHtml::image(Yii::app()->getBaseUrl() . '/files/images/testimonials/Anam.jpg') .
                       '<br>Anam Basharat<br>Quality Assurance Analyst<br>Scotiabank';
             }
         ?>
</blockquote>

<hr><hr>

<blockquote>
    <p>Collegecornerstone.com has enormous potential for ICT students and employers. Using the 
       tested concept of Business Networking, it is truly unlocking that 80% of the hidden job 
       market.Finding the right skill and experience is critical in the IT industry and 
       Collegecornerstone helps solicit and provide critical information at your fingertips.</p>
       <br>
       Christine Robson, MSIS, PMP <br>
       IT Director Durham Regional Police & Continuing Education Instructor<br>
</blockquote>

<hr><hr>

<blockquote>

    <p>Collegecornerstone.com has most certainly made it easier to find suitable candidates for 
       our Scotiabank  Work  Program in partnership with  Centennial College. Many of the candidates 
       have subsequently moved into successful IT careers with Scotiabank.</p>
       <br>
       Farrah Gulston<br>
       Senior Analyst at Scotiabank<br>

</blockquote>

<hr><hr>

