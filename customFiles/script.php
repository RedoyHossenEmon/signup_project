<?php



class Script {
 public function __construct($text){
  
  echo "
  function generateText(msg) {
    let index = 0;
    const autoText = document.getElementById('autoText');
  
    const interval = setInterval(() => {
      if (index < msg.length) {
        autoText.innerHTML += msg.charAt(index);
        index++;
      } else {
        clearInterval(interval);
      }
    }, 50);
  }
  
  generateText('$text');";
  
 }
  
}




// form inputed value back if not signedup=------------------------


if(isset($_COOKIE['inputname'])){
  $inputname = $_COOKIE['inputname'];
  echo" document.querySelector('#name').value= '$inputname';";
}

if(isset($_COOKIE['inputemail'])){
  $inputemail = $_COOKIE['inputemail'];
  echo" document.querySelector('#email').value= '$inputemail';";
}
if(isset($_COOKIE['focus'])){
  $focusId = $_COOKIE['focus'];
  echo" document.querySelector('input#$focusId').focus()";
}

echo'
function addValueTokenSelector(token,selector){
  document.querySelector(".tokenadd").value = token;
  document.querySelector(".selectoradd").value = selector;
};'



?>