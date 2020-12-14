$(document).ready(function() {
  console.log('Hello');
  $("#PsigninForm").validate({
    rules: {
          email: {
            required: true,
            email: true
          },
          pass: {
            required: true
          }
    }
  });
});