class Validator {

    validate(model, rules) {
        let errors = '';
        for (let fieldName in rules) {
            const value = model[fieldName];
            const validators = rules[fieldName].split('|');

            validators.map((validatorMethod) => {
                if (!this[validatorMethod](value)) {
                    errors += this[validatorMethod + 'Msg'](fieldName) + ' ## ';
                }
            })
        }

        if (errors) {
            return { errors: errors.slice(0, -4) };
        }
        return true;
    }

    __call() {
        return false;
    }

    filled(value) {
        value = '' + value;
        return !!value.trim();
    }

    filledMsg(fieldName) { return 'Field "' + fieldName + '" does not filled'; }

    phone(value) {
        value = '' + value;
        return true;
    }

    phoneMsg(fieldName) { return 'Please provide valid phone number to "' + fieldName + '" field'; }
}