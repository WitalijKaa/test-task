# some pictures approver

#### https://test12.magic-stone-circuit.app/

## test-task

### use Yii2 or Laravel, PostgreSQL, nginx and Docker

### create web-page where you can approve pictures from https://picsum.photos/

- get photo using https://picsum.photos/v2/list/?
- just show picture and APPROVE DECLINE buttons
- save action to DB as async query
- save pictures with id of picsum.photos id

### create admin-page where you can watch processed result

- access to page using GET-param ?token=xyz123
- show table with columns: ID, process-result, cancel-process button

## to make it work:

# docker-compose up

## http://localhost:3001/

## http://localhost:3001/adm?token=xyz123

Fresh tests...

I have got this working only after second launch of "docker-compose up" in Linux. Looks like first time postgres wasnt runned on the moment when migrations starts. Weird.

I used nginx.debian11.conf to make my Debian11 dev server worked as a proxy. 

The demo here https://test12.magic-stone-circuit.app/

## upd: nicer docker

https://github.com/WitalijKaa/test-task/tree/task_12_3
