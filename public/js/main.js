
$("#game-vip").hide();
$("#game-premium").hide();


$("#roulette-premium").click(function(){
    roulette.Roulette();
});
$("#roulette-vip").click(function(){
    roulette.Roulette();
});
$("#button-take").click(function() {
    roulette.TakeKey("");
});
$("#button-sell").click(function() {
    roulette.KeySellWindow();
});
$("#button-pay").click(function(){
    view.OpenWindow("#window-pay");
    view.BalanceUpdate();
    user.GetBalance();
});
$("#button-premium").click(function(){
    roulette.OpenPremiumCase();
});
$(".premium").click(function(){
    roulette.OpenPremiumCase();
});
$("#button-vip").click(function(){
    roulette.OpenVIPCase();
});
$(".vip").click(function(){
    roulette.OpenVIPCase();
})
$(".activate-info").click(function(){
    window.open("guarantees");
});

roulette.GetCasePrice();


