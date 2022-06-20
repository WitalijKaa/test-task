class Validator {

    static lastMessageBag = {};

    messageBag = {};

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

                    if (!this.constructor.lastMessageBag.hasOwnProperty(fieldName)) {
                        this.constructor.lastMessageBag[fieldName] = [];
                    }
                    this.constructor.lastMessageBag[fieldName].push(errorMsg)
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
        return value.match(/^\+?[0-9-]+$/);
    }

    phoneMsg(fieldName) { return 'Please provide valid phone number to "' + fieldName + '" field'; }
}