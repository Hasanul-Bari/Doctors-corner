$(document).ready(function() {
  
  $("#PsignupForm").validate({
    rules: {
          Pname: {
            required: true,
            minlength: 3
          },
          email: {
            required: true,
            email: true
          },
          pass: {
            required: true,
            minlength: 5
          },
          dob: {
            required: true,
          },
          gender: {
            required: true
          },
          phone: {
            required: true
          },
          height: {
            required: true
          },
          weight: {
            required: true
          }
    },
    
    errorPlacement: function(error, element) {
        if ( element.is(":radio") ) 
        {
            error.insertAfter('#gnTitle');
        }
        else 
        { // This is the default behavior 
            error.insertAfter( element );
        }
     }
  });
});