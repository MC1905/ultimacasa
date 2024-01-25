function checkPasswordStrength() {
    var password = document.getElementById('Wachtwoord');
    var meter = document.getElementById('password-strength-meter');
    var strength = 0;
    var color = '';

    if (password.value.length >= 8) {
        strength += 1;
    }

    // You can add more conditions to check for uppercase, lowercase, numbers, special characters, etc.

    switch(strength) {
        case 0:
            color = 'red';
            break;
        case 1:
            color = 'orange';
            break;
        case 2:
            color = 'yellow';
            break;
        case 3:
            color = 'green';
            break;
        default:
            break;
    }

    meter.style.width = (strength * 25) + '%';
    meter.style.backgroundColor = color;
}
