/*
The popUp() function is vulnerable to clickjacking attacks because it opens a new window with fixed 
dimensions and properties. To improve security, the function should use a different method to display the
 content, such as an iframe or a modal dialog box.
The validate_required() function is vulnerable to cross-site scripting (XSS) attacks because it does not
 sanitize the input. To fix this, the function should sanitize the input and escape any special characters 
 before displaying the alert message.
The validateGuestbookForm() function is vulnerable to form tampering attacks because it only checks if the
required fields are not empty. To improve security, the function should also validate the input format and length, and sanitize the input before storing it in the database.
The confirmClearGuestbook() function is vulnerable to clickjacking attacks because it displays a confirmation
 dialog box. To improve security, the function should use a different method to confirm the action, such as a checkbox or a CAPTCHA.
*/

/* Help popup function that opens a new window with the specified URL */

function popUp(URL) {
  // Get the current date and time and use it as the window ID
  day = new Date();
  id = day.getTime();
  
  // Open a new window with the specified URL and window properties
  window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=300,left=540,top=250');
  
  // Alternative method using eval() to open a new window
  //eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=300,left=540,top=250');");
}

/* Form validation functions */

// Function to validate a required field and display an alert message if it is empty
function validate_required(field,alerttxt)
{
  with (field) {
      if (value==null||value=="") {
          alert(alerttxt);
          return false;
      }
      else {
          return true;
      }
  }
}

// Function to validate the guestbook form and check if the required fields are not empty
function validateGuestbookForm(thisform) {
  with (thisform) {
      // Check if the name field is not empty
      if (validate_required(txtName,"Name can not be empty.")==false)
      {
          txtName.focus();
          return false;
      }
      
      // Check if the message field is not empty
      if (validate_required(mtxMessage,"Message can not be empty.")==false)
      {
          mtxMessage.focus();
          return false;
      }
  }
}

// Function to confirm if the user wants to clear the guestbook
function confirmClearGuestbook() {
  return confirm("Are you sure you want to clear the guestbook?");
}