class AbstractModelPresenter {

    _parentEventController;
    _parentEventsSubscriptions = {};

    emitEvent(eventName, params) {
        if (this._parentEventController) {
            this._parentEventController.handleEvent(eventName, params);
        }
    }

    handleParentEvent(eventName, params) {
        if (this._parentEventsSubscriptions.hasOwnProperty(eventName)) {
            this[this._parentEventsSubscriptions[eventName]](...params);
        }
    }

    injectParentEventsController(controller) {
        if (controller instanceof ParentEventController) {
            this._parentEventController = controller;
        }
    }

    _element;

    _getElem(dataID) {
        return this._element.querySelector('[data-elem-id="' + dataID + '"]');
    }

    _addEventHandler(dataID, type, method) {
        this._getElem(dataID).addEventListener(type, () => {
            this[method]();
        })
    }

    _addClass(dataID, className) {
        this._getElem(dataID).classList.add(className);
    }

    _removeClass(dataID, className) {
        this._getElem(dataID).classList.remove(className);
    }
}