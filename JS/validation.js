// Creating a new JustValidate object.
const validation = new JustValidate("#signup");

// Adding validation rules for input fields.
validation
  // Validation rules for name.
  .addField("#name", [
    {
      rule: "required"
    }
  ])
  // Validation rules for email.
  .addField("#email", [
    {
      rule: "required"
    },
    {
      rule: "email"
    },
    {
      // validator: (value) => () => {
      validator: (value) => {
        return fetch("validate-email.php?email=" + encodeURIComponent(value))
          .then(function(response) {
            return response.json();
          })
          .then(function(json) {
            return json.available;
        });
      },
      errorMessage: "Email already taken."
    }
  ])
  // Validation rules for password.
  .addField("#password", [
    {
      rule: "required"
    },
    {
      rule: "password"
    }
  ])
  // Confirm password must be same as the password.
  .addField("#cPassword", [
    {
      validator: (value, fields) => {
        return value === fields["#password"].elem.value;
      },
      errorMessage: "Passwords must match!"
    }
  ])
  //  Submits the form if no errrors are found.
  .onSuccess((Event) => {
    document.getElementById("signup").submit();
  });
