'use strict';

class Controller {

    actionFakeHumans() {
        const apiTodo = [
            ['Omar Hajam', '+1234-5'],
            ['Anatolij Kuznecov', '+1234-6'],
            ['Mihajlo Kucubinskij', '+1234-7'],
            ['John Ronald Reuel Tolkien', '+1234-8'],
            ['Eva', '+1234-9'],
        ];

        const table = document.getElementById('humans');

        apiTodo.map((person) => {
            let model = new Human();
            model.name = person[0];
            model.phone = person[1];

            let presenter = new HumanPresenter(model);

            if (presenter.element) {
                table.appendChild(presenter.element);
            }
        })
    }

}