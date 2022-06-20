'use strict';

class Controller {

    table;
    eventsController;

    idInDB = 100;

    beforeActions() {
        this.table = document.getElementById('humans');
        this.eventsController = new ParentEventController();
    };

    actionGenerateHumans() {
        const apiTodo = [
            [1, 'Omar Hajam', '+1234-5'],
            [2, 'Anatolij Kuznecov', '+1234-6'],
            [3, 'Mihajlo Kucubinskij', '+1234-7'],
            [4, 'John Ronald Reuel Tolkien', '+1234-8'],
            [5, 'Eva', '+1234-9'],
        ];

        // fetch('http://some-cool/api/v1/human')
        //     .then(response => response.json())
        //     .then(data => {
        //         // do the things like in .map() below
        //     });

        apiTodo.map((person) => {
            let model = new Human();
            model.id = person[0];
            model.name = person[1];
            model.phone = person[2];

            this._addHuman(model);
        })
    }

    actionAddHuman() {
        GlobalEventController.emitEvent('hideValidationErrorsForElements');
        let name = document.getElementById('human-name').value;
        let phone = document.getElementById('human-phone').value;

        let model = new Human();
        model.id = this.idInDB++;
        model.name = name;
        model.phone = phone;

        if (model.saveByApi()) {
            this._addHuman(model);

            document.getElementById('human-name').value = '';
            document.getElementById('human-phone').value = '';
        }
        else {
            GlobalEventController.emitEvent('showValidationErrorsForElements', [{
                name: document.getElementById('name-error'),
                phone: document.getElementById('phone-error'),
            }]);
        }
    }

    _addHuman(model) {
        let presenter = new HumanPresenter(model);

        this.eventsController.models.push(presenter);
        presenter.injectParentEventsController(this.eventsController);

        if (presenter.element) {
            this.table.appendChild(presenter.element);
        }
    }
}