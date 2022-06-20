class Human {
    name;
    _phone;

    get phone() {
        return this._phone;
    }

    set phone(val) {
        this._phone = val;
    }
}

class HumanPresenter {
    humanModel;
    _element;

    constructor(human) {
        if (human instanceof Human) {
            this.humanModel = human;
        }
    }

    get element() {
        if (this._element) { return this._element; }
        return this.createElement();
    }

    createElement() {
        if (!this.humanModel || this._element) { return null; }

        this._element = document.createElement("div");
        this._element.classList.add("table__row");
        this._element.classList.add("user-row");
        this._element.classList.add("user-row--view");

        this._element.innerHTML =
            '<div class="table__row-content">\n' +
            '    <div class="table__row-cell user-row--name">\n' +
            '        <span>' + this.humanModel.name + '</span>\n' +
            '        <div class="input input--full-width">\n' +
            '            <input class="input__input" name="user-name">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="table__row-cell user-row--phone">\n' +
            '        <span>' + this.humanModel.phone + '</span>\n' +
            '        <div class="input">\n' +
            '            <input class="input__input" name="user-name">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>\n' +
            '<div class="table__control">\n' +
            '    <div class="table__control-container">\n' +
            '        <div class="table__button button button--green button--hidden">Save</div>\n' +
            '        <div class="table__button button button--green">Edit</div>\n' +
            '        <div class="table__button button button--red">Delete</div>\n' +
            '    </div>\n' +
            '</div>\n';

        return this._element;
    }


}