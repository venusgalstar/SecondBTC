"use strict";



$(document).ready(function() {

    $('#preloader').fadeOut('normall', function() {
      $(this).remove();
    });
    
    $.fn.toPlainString = function(num) { 
        return (''+ +num).replace(/(-?)(\d*)\.?(\d*)e([+-]\d+)/,
          function(a,b,c,d,e) {
            return e < 0
              ? b + '0.' + Array(1-e-c.length).join(0) + c + d
              : b + c + d + Array(e-d.length+1).join(0);
          }); 
    }
    
    $.fn.formattedNumber = function(number) { 
        var input = parseFloat(number)
        var finalNumber = 0
        var value = input.toFixed(2);
        var output = value.split('.')[1];
        if(output == "00") {
            if($.fn.toPlainString(input).split(".").length > 1) {
                var len = $.fn.toPlainString(input).split(".")[1].length
                var zeroval = input.toFixed(len).split('.')
                var data =zeroval[1].split('')
                
                // using loop to find number of Zero. 
                var zero_count = 0
                var afterZero = 0
                var rem_no = ''
                for(let x in data){
                    if(data[x] == 0 && afterZero ==0){
                        zero_count = zero_count+1
                    }else{
                            afterZero = 1
                            rem_no = rem_no + data[x].toString();
                    }
                    }
                    // using for loop to find Unicode for subscript
                    
                    var j = zero_count.toString().split('')
                    
                    var dict1 = {'0':'\u2080','1':'\u2081','2':'\u2082','3':'\u2083','4':'\u2084','5':'\u2085','6':'\u2086','7':'\u2087','8':'\u2088','9':'\u2089'}
                    var sub_script= ''
                    for(let i in j){
        
                    sub_script = sub_script+dict1[j[i]]
                    }
                    finalNumber = zeroval[0]+".0"+sub_script+rem_no.slice(0,2)
                    console.log(finalNumber)
                    return finalNumber
                    
                }else{
                    console.log(input.toFixed(2))
                    return input.toFixed(2)
                } 
        }else{
            // console.log(output)
            console.log(input.toFixed(2))
            return input.toFixed(2)
        }
        
    }
      
    
});

if($("#video-area").length !== 0) {
  $('#video-play').mb_YTPlayer();
}

