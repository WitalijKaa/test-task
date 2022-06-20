'use strict';

const controller = new Controller();
controller.beforeActions();
controller.actionFakeHumans();
document.getElementById('add-human').addEventListener('click', () => {
    controller.actionAddHuman()
})
