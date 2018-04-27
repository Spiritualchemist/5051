function validate() {    
var s_title = document.getElementById("s_title").value;   
 var s_artist = document.getElementById("s_artist").value;    
 var s_genre = document.getElementById("s_genre").value;   
  var s_year = document.getElementById("s_year").value;    
  var s_email = document.getElementById("s_email").value;    
  if (s_title.trim() == "") {        
  document.getElementById('s_title_avail').style.display = 'block';       
   document.getElementById("s_title").focus();        return false;   
    } else {        
    document.getElementById('s_title_avail').style.display = 'none';   
     }    if (s_artist.trim() == "") {       
      document.getElementById('s_artist_avail').style.display = 'block';       
       document.getElementById("s_artist").focus();        
       return false;   
        } else {        
        document.getElementById('s_artist_avail').style.display = 'none';    
        }    if (s_genre.trim() == "") {       
         document.getElementById('s_genre_avail').style.display = 'block';       
          document.getElementById("s_genre").focus();        return false;    
          } else {        
          document.getElementById('s_genre_avail').style.display = 'none';   
           }    
           if (s_year.trim() == "") {        
           document.getElementById('s_year_avail').style.display = 'block';        
           document.getElementById("s_year").focus();        
           return false;   
            } else {        
            document.getElementById('s_year_avail').style.display = 'none';   
             }    
             if (isNaN(s_year)) {        
             document.getElementById('s_year_valid').style.display = 'block';       
              document.getElementById("s_year").focus();       
               return false;    
               } else {       
                document.getElementById('s_year_valid').style.display = 'none';   
                 }    
                 if (s_year.length != 4) {        
                 document.getElementById('s_year_valid').style.display = 'block';        
                 document.getElementById("v").focus();       
                  return false;    
                  } else {       
                   document.getElementById('s_year_valid').style.display = 'none';   
                    }    if (s_email.trim() == "") {       
                     document.getElementById('s_email_avail').style.display = 'block';        
                     document.getElementById("s_email").focus();       
                      return false;    
                      } else {        
                      document.getElementById('s_email_avail').style.display = 'none';    
                      }    
                      var s_emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;   
                       if (!s_emailPattern.test(s_email)) {       
                        document.getElementById('s_email_valid').style.display = 'block';       
                         document.getElementById("s_email").focus();        
                         return false;   
                          } else {       
                           document.getElementById('s_email_avail').style.display = 'none';    
                           }
                           }