class Human {
    id;
    _name;
    _phone;

    _prevAttributes = {};

    get rules() {
        return {
            name: 'filled',
            phone: 'filled|phone',
        }
    }

    get name() {
        return this._name;
    }

    set name(val) {
        this._prevAttributes.name = this._name;
        this._name = val;
    }

    get phone() {
        return this._phone;
    }

    set phone(val) {
        this._prevAttributes.phone = this._phone;
        this._phone = val;
    }

    deleteByApi() {
        return true;
    }

    saveByApi() {
        const validation = (new Validator()).validate(this, this.rules);

        if (true !== validation) {
            //GlobalEventController.emitEvent('msg', [validation.errors]);

            for (let attrName in this._prevAttributes) {
                if (this._prevAttributes.hasOwnProperty(attrName)) {
                    this['_' + attrName] = this._prevAttributes[attrName];
                }
            }

            return false;
        }
        this._prevAttributes = {};
        return true;
    }
}
