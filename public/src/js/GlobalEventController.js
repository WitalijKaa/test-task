class GlobalEventController {

    static emitEvent(name, params) {
        if ('function' == typeof this[name]) {
            this[name](...params);
        }
    }

    static msg(msg) { alert(msg); }
}