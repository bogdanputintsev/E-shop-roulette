console.info(location.pathname);

let view = new View();
let data = new Data();
let dataRoulette = new DataRoulette();
let dataCases = new DataCases();
let dataUser = new DataUser();
let tape = data.LiveTape();

view.UsersOnline();
view.BalanceUpdate();
view.LiveTapeStart();

let user = new User();
user.GetUserInfo();

setInterval(function()
{
    view.LiveTapeUpdate();
    view.UsersOnline();
}, 3000);

document.body.onload = function () {
    setTimeout(function() {
        let preloader = document.getElementById("preloader");
        preloader.classList.add("done");
    }, 300);
};




