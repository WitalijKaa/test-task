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

    deleteByApi() {
        return true;
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

    get _isActiveElement() {
        return !!(this.dataModel && this._element);
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
        this._addEventHandler('save', 'click', 'saveModel');
        this._addEventHandler('delete', 'click', 'deleteModel');
    }

    toggleEditMode() {
        if (!this._isActiveElement) { return; }

        if (this._editMode) {
            this._removeClass('edit', 'elem--hidden');
            this._addClass('save', 'elem--hidden');
            this._removeClass('name', 'elem--hidden');
            this._removeClass('phone', 'elem--hidden');
            this._addClass('name-edit-container', 'elem--hidden');
            this._addClass('phone-edit-container', 'elem--hidden');
        }
        else {
            this._getElem('name-edit').value = this.dataModel.name;
            this._getElem('phone-edit').value = this.dataModel.phone;
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
        if (!this._isActiveElement) { return; }

        if (this.dataModel.id != id && this._editMode) {
            this.toggleEditMode();
        }
    }

    deleteModel() {
        if (!this._isActiveElement) { return; }

        if (this.dataModel.deleteByApi()) {
            this.dataModel = null;
            this._element.remove();
        }
    }

    saveModel() {
        let name = this._getElem('name-edit').value;
        let phone = this._getElem('phone-edit').value;

        this.dataModel.name = name;
        this.dataModel.phone = phone;

        this._getElem('name').innerText = this.dataModel.name;
        this._getElem('phone').innerText = this.dataModel.phone;

        this.toggleEditMode();
    }
}