class ParentEventController {

    models = [];

    handleEvent(eventName, params) {
        this.models.map((model) => {
            model.handleParentEvent(eventName, params)
        })
        GlobalEventController.emitEvent(eventName, params);
    }
}