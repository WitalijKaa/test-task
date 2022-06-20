'use strict';

const controller = new Controller();
controller.beforeActions();
controller.actionGenerateHumans();
document.getElementById('add-human').addEventListener('click', () => {
    controller.actionAddHuman()
})
