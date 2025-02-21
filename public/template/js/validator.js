function Validator(options) {
    var formElement = document.querySelector(options.form);
    if (formElement) {
        options.rules.forEach(function (rule) {
            var inputElement = formElement.querySelector(rule.selector);
            var errorElement = inputElement.parentElement.querySelector('.error-message');
            if (inputElement) {
                // Khi click ra ngoai input
                inputElement.onblur = function() {
                    var errorMsg = rule.test(inputElement.value);
                    if (errorMsg) {
                        errorElement.innerText = errorMsg;
                    }
                    else {
                        errorElement.innerText = '';
                    }
                }
                // Khi typing
                inputElement.oninput = function() {
                    errorElement.innerText = '';
                }
            }
        })
    }
}

Validator.isRequired = function (selector) {
    return {
        selector: selector,
        test: function(value) {
            return value.trim() ? undefined : 'Vui lòng nhập trường này!'
        }
    }

}

Validator.isEmail = function (selector) {
    return {
        selector: selector,
        test: function(value) {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return emailPattern.test(value) ? undefined : 'Vui lòng nhập email đúng định dạng (abc@email.com)'
        }
    }
}

Validator.isTel = function (selector) {
    return {
        selector: selector,
        test: function(value) {
            return value.trim().length == 10 ? undefined : 'Vui lòng nhập số điện thoại gồm 10 số!'
        }
    }
}

Validator.minLength = function (selector, minLen) {
    return {
        selector: selector,
        test: function(value) {
            return value.trim().length >= minLen ? undefined : `Vui lòng nhập ít nhất ${minLen} ký tự!`
        }
    }
}

Validator.isConfirmed = function (selector, getConfirmValue) {
    return {
        selector: selector,
        test: function(value) {
            return value === getConfirmValue() ? undefined : 'Mật khẩu nhập lại không khớp!'
        }
    }
}