class Validator {

    static lastMessageBag = {};

    validate(model, rules) {
        this.constructor.lastMessageBag = {};

        let errors = '';
        for (let fieldName in rules) {
            const value = model[fieldName];
            const validators = rules[fieldName].split('|');

            validators.map((validatorMethod) => {
                if (!this[validatorMethod](value)) {
                    let errorMsg = this[validatorMethod + 'Msg'](fieldName);

                    errors += errorMsg + ' ## ';
                    this.addToMessageBag(fieldName, errorMsg);
                }
            })
        }

        if (errors) {
            return { errors: errors.slice(0, -4) };
        }
        return true;
    }

    addToMessageBag(fieldName, errorMsg) {
        if (!this.constructor.lastMessageBag.hasOwnProperty(fieldName)) {
            this.constructor.lastMessageBag[fieldName] = [];
        }
        this.constructor.lastMessageBag[fieldName].push(errorMsg)
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
        return value.match(/^\+?[0-9-]{5,20}$/);
    }

    phoneMsg(fieldName) { return 'Please provide valid phone number to "' + fieldName + '" field'; }
}