
$("#roulette-premium").click(function(){
    roulette.Roulette();
});
$("#button-take").click(function() {
    roulette.TakeKey("");
});
$("#button-sell").click(function() {
    roulette.KeySellWindow();
});
$(".activate-info").click(function(){
    window.open("guarantees");
});
$("#writeFeedback").click(function(){
    view.WriteFeedback();
});
$("#joinGroup").click(function () {
    window.open("guarantees");
});

roulette.GetProducts();