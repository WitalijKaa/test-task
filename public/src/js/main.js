'use strict';

const controller = new Controller();
controller.beforeActions();
controller.actionGenerateHumans();
document.getElementById('add-human').addEventListener('click', () => {
    controller.actionAddHuman()
})

const miniTask = new MiniTaskController();
miniTask.beforeActions();
miniTask.actionStars();