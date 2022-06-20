class Human {
    id;
    name;
    _phone;

    get phone() {
        return this._phone;
    }

    set phone(val) {
        this._phone = val;
    }
}

class HumanPresenter extends AbstractModelPresenter {
    dataModel;
    _editMode = false;

    _parentEventsSubscriptions = {
        'editModeOnAtElement': 'handleEditModeOnInGroup',
    }

    constructor(human) {
        super();
        if (human instanceof Human) {
            this.dataModel = human;
        }
    }

    get element() {
        if (this._element) { return this._element; }
        return this.createElement();
    }

    createElement() {
        if (!this.dataModel || this._element) { return null; }

        this._element = document.createElement("div");
        this._element.classList.add("table__row");
        this._element.classList.add("user-row");
        this._element.classList.add("user-row--view");

        this._element.innerHTML =
            '<div class="table__row-content">\n' +
            '    <div class="table__row-cell user-row--name">\n' +
            '        <span data-elem-id="name">' + this.dataModel.name + '</span>\n' +
            '        <div data-elem-id="name-edit-container" class="input input--full-width elem--hidden">\n' +
            '            <input data-elem-id="name-edit" class="input__input" name="user-name">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="table__row-cell user-row--phone">\n' +
            '        <span data-elem-id="phone">' + this.dataModel.phone + '</span>\n' +
            '        <div data-elem-id="phone-edit-container" class="input elem--hidden">\n' +
            '            <input data-elem-id="phone-edit" class="input__input" name="user-name">\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>\n' +
            '<div class="table__control">\n' +
            '    <div class="table__control-container">\n' +
            '        <div data-elem-id="save" class="table__button button button--green elem--hidden">Save</div>\n' +
            '        <div data-elem-id="edit" class="table__button button button--green">Edit</div>\n' +
            '        <div data-elem-id="delete" class="table__button button button--red">Delete</div>\n' +
            '    </div>\n' +
            '</div>\n';

        this.subscribeToEvents();
        return this._element;
    }

    subscribeToEvents() {
        if (!this._element) { return; }

        this._addEventHandler('edit', 'click', 'toggleEditMode');
        this._addEventHandler('save', 'click', 'toggleEditMode');
    }

    toggleEditMode() {
        if (this._editMode) {
            this._removeClass('edit', 'elem--hidden');
            this._addClass('save', 'elem--hidden');
            this._removeClass('name', 'elem--hidden');
            this._removeClass('phone', 'elem--hidden');
            this._addClass('name-edit-container', 'elem--hidden');
            this._addClass('phone-edit-container', 'elem--hidden');
        }
        else {
            this._addClass('edit', 'elem--hidden');
            this._removeClass('save', 'elem--hidden');
            this._addClass('name', 'elem--hidden');
            this._addClass('phone', 'elem--hidden');
            this._removeClass('name-edit-container', 'elem--hidden');
            this._removeClass('phone-edit-container', 'elem--hidden');
        }
        this._editMode = !this._editMode;
        
        if (this._editMode) {
            this.emitEvent('editModeOnAtElement', [this.dataModel.id]);
        }
    }
    
    handleEditModeOnInGroup(id) {
        if (this.dataModel.id != id && this._editMode) {
            this.toggleEditMode();
        }
    }
}