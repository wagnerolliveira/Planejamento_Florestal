document.addEventListener('DOMContentLoaded', function () {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.getElementById('togglePassword');

    toggleIcon.addEventListener('click', function () {
      togglePasswordVisibility();
    });

    function togglePasswordVisibility() {
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.innerHTML = '<i class="mdi mdi-eye-outline"></i>';
      } else {
        passwordInput.type = 'password';
        toggleIcon.innerHTML = '<i class="mdi mdi-eye-off-outline"></i>';
      }
    }
  });