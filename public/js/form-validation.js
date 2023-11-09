// Dodaj zdarzenie dla przycisku Submit
(function () {
  'use strict';

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation');

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();

        // Przewiń do pierwszego pola z błędem i ustaw na nim fokus
        var firstInvalidField = form.querySelector(':invalid');
        if (firstInvalidField) {
          firstInvalidField.scrollIntoView({
            behavior: 'smooth'
          });
          firstInvalidField.focus();
        }
      }

      form.classList.add('was-validated');
    }, false);
  });
})();
