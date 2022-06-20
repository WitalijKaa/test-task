'use strict';

class Controller {

    actionFakeHumans() {
        const apiTodo = [
            [1, 'Omar Hajam', '+1234-5'],
            [2, 'Anatolij Kuznecov', '+1234-6'],
            [3, 'Mihajlo Kucubinskij', '+1234-7'],
            [4, 'John Ronald Reuel Tolkien', '+1234-8'],
            [5, 'Eva', '+1234-9'],
        ];

        const table = document.getElementById('humans');
        const eventsController = new ParentEventController();

        apiTodo.map((person) => {
            let model = new Human();
            model.id = person[0];
            model.name = person[1];
            model.phone = person[2];

            let presenter = new HumanPresenter(model);

            eventsController.models.push(presenter);
            presenter.injectParentEventsController(eventsController);

            if (presenter.element) {
                table.appendChild(presenter.element);
            }
        })
    }

}