class GlobalEventController {

    static emitEvent(name, params) {
        if (!params) { params = []; }
        if ('function' == typeof this[name]) {
            this[name](...params);
        }
    }

    static msg(msg) { alert(msg); }

    static hideValidationErrorsForElements() {
        for (let elem of document.querySelectorAll('[data-elem-type="show-validation-error"]')) {
            if (!elem.classList.contains('elem--hidden')) {
                elem.classList.add('elem--hidden');
            }
        }
    }

    static showValidationErrorsForElements(elementsByKeys) {
        for (let fieldName in elementsByKeys) {
            let elem = elementsByKeys[fieldName];

            for (let errorFieldName in Validator.lastMessageBag) {
                if (errorFieldName != fieldName) {
                    continue;
                }
                if (Validator.lastMessageBag[errorFieldName].length) {
                    elem.innerText = Validator.lastMessageBag[errorFieldName][0];
                    elem.classList.remove('elem--hidden');
                }
                break;
            }
        }
    }
}