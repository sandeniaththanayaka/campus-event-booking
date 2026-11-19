// Helper: field එකක් වැරදි/හරි කියලා පෙන්වනවා
function setValid(input, isValid) {
    if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }
    return isValid;
}

// Email format පරීක්ෂාව
function isValidEmail(email) {
    var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

// ===== Register form =====
var registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function (event) {
        var fullName = document.getElementById('full_name');
        var studentId = document.getElementById('student_id');
        var email = document.getElementById('email');
        var password = document.getElementById('password');
        var confirmPassword = document.getElementById('confirm_password');

        var ok = true;
        ok = setValid(fullName, fullName.value.trim() !== '') && ok;
        ok = setValid(studentId, studentId.value.trim() !== '') && ok;
        ok = setValid(email, isValidEmail(email.value.trim())) && ok;
        ok = setValid(password, password.value.length >= 6) && ok;
        ok = setValid(confirmPassword,
            confirmPassword.value !== '' && confirmPassword.value === password.value) && ok;

        // වැරදි තියෙනවා නම් form එක යවන්න දෙන්නේ නැහැ
        if (!ok) {
            event.preventDefault();
        }
    });
}

// ===== Login form =====
var loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function (event) {
        var email = document.getElementById('email');
        var password = document.getElementById('password');

        var ok = true;
        ok = setValid(email, isValidEmail(email.value.trim())) && ok;
        ok = setValid(password, password.value !== '') && ok;

        if (!ok) {
            event.preventDefault();
        }
    });
}