
class Roulette
{
    inner = $(".elements-inner");
    blockPx = this.inner.children().first().outerWidth();
    roll_offset;
    roll_speed = 0;
    offset = null;
    result = null;
    lastIncome = 0;
    lastResult;
    case_show_speed = 1000;
    case_hide_speed = 500;
    tapeShowSpeed = 1000;
    tapeHideSpeed = 500;
    bonusesTimerH = null;
    bonusesTimerM = null;
    bonus_group_gift = null;
    bonus_feedback_gift = null;
    caseOpened = -1;
    case_price = null;
    premium = null;
    vip = null;
    game = null;

    GetCasePrice()
    {
        this.case_price = dataCases.GetBasicCasePrice();
        this.premium = dataCases.GetCaseProducts(1);
        this.vip = dataCases.GetCaseProducts(2);
    }
    GetProducts()
    {
        this.case_id = parseInt($("#case_id").text());
        this.case_price = dataCases.GetCasePrice(this.case_id);
        this.game = dataCases.GetCaseProducts(this.case_id);
        roulette.caseOpened = roulette.case_id;
    }
    LoadConfigs()
    {
        var e = data.LoadConfigs();
        this.maintenance = e.maintenance;
        this.roll_offset = e.roll_offset;
        this.roll_speed = e.roll_speed;
        this.case_show_speed = e.case_show_speed;
        this.case_hide_speed = e.case_hide_speed;
        this.tapeShowSpeed = e.tapeShowSpeed;
        this.tapeHideSpeed = e.tapeHideSpeed;
        this.bonusesTimerH = e.bonusesTimerH;
        this.bonusesTimerM = e.bonusesTimerM;
        this.bonus_group_gift = e.bonus_group_gift;
        this.bonus_feedback_gift = e.bonus_feedback_gift;
    }
    OpenPremiumCase()
    {
        if(this.result != -1 && this.inner.css("left") != "0px") {
            this.inner.animate({left: "+=500px"}, 700, function(){
                this.inner.css("left", "0px");
            });
        }
        if(this.result != -1)
        {
            $(".block").removeClass("case-active");
            $(".premium").addClass("case-active");
            $("#game-vip").fadeOut(this.case_hide_speed);
            $("#game-premium").show(this.case_show_speed);
            this.caseOpened = 0;
            console.info("Открыл кейс Premium");
        }
    }
    OpenVIPCase()
    {
        if(this.result != -1 && this.inner.css("left") != "0px") {
            this.inner.animate({left: "+=500px"}, 700, function(){
                this.inner.css("left", "0px");
            });
        }
        if(this.result != -1)
        {
            $(".block").removeClass("case-active");
            $(".vip").addClass("case-active");
            $("#game-premium").fadeOut(this.case_hide_speed);
            $("#game-vip").show(this.case_show_speed);
            this.caseOpened = 1;
            console.info("Открыл кейс VIP");
        }
    }
    Roulette()
    {
        console.info(this.caseOpened);
        if(this.result == null && this.RouletteCheck() == true)
        {
            this.offset = this.blockPx * (this.roll_offset - 2);
            console.info("Запуск рулетки...");
            this.result = -1;

            let sound = document.getElementById("audio");
            sound.play();
            this.inner.animate({left: "-=" + this.offset}, this.roll_speed, "swing")
                .promise().done(function() {
                $(".arrow").css("display", "none");

                roulette.result = document.elementFromPoint(window.innerWidth / 2,$("#elements-" + roulette.caseOpened).offset().top + 10 - $(window).scrollTop());
                if(roulette.result != -1 && roulette.result != null) {
                    roulette.result = roulette.result.id;
                    roulette.lastResult = roulette.result;
                    $(".arrow").css("display", "inline-block");
                    console.info("Конец рулетки");
                    if(roulette.caseOpened == 0 && roulette.result && roulette.premium[roulette.result]['name'] && roulette.premium[roulette.result]['image_key'] && roulette.premium[roulette.result]['price_sell']) {
                        $("#window-name").text(roulette.premium[roulette.result]['name']);
                        $("#window-sell-name").text(roulette.premium[roulette.result]['name']);
                        $("#window-image").css("background", "url(/img/game/" + roulette.premium[roulette.result]['image_key'] + "-WIDE.png) no-repeat center");
                        $("#window-sell-image").css("background", "url(/img/game/" + roulette.premium[roulette.result]['image_key'] + "-WIDE.png) no-repeat center");
                        $("#button-sell").text("Продать за " + roulette.premium[roulette.result]['price_sell'] + "₽");
                        $("#button-take").css("display", "inline-block");
                        console.info(roulette.premium[roulette.result]['type']);
                        if(roulette.premium[roulette.result]['type'] == 3 || roulette.premium[roulette.result]['type'] == 4) {
                            $("#button-sell").text("Забрать выигрыш");
                            $("#button-take").css("display", "none");
                        }

                        $("#game-premium").load(document.URL+" #game-premium>*", function() {
                            roulette.inner = $(".elements-inner");
                            roulette.offset = null;
                            roulette.result = null;
                            $("#game-vip .elements-inner").css('left', '0');
                            $("#roulette-premium").click(function(){
                                roulette.Roulette();
                            });
                            console.info("Рулетка Премиум обновлена");
                        });
                        view.OpenWindow("#window");
                        if(roulette.premium[roulette.result]['type'] == 4 )
                            roulette.KeySell("twokeys");
                        else
                            roulette.KeySell();
                    }
                    else if(roulette.caseOpened == 1 && roulette.result && roulette.vip[roulette.result]['name'] && roulette.vip[roulette.result]['image_key'] && roulette.vip[roulette.result]['price_sell']) {
                        $("#window-name").text(roulette.vip[roulette.result]['name']);
                        $("#window-sell-name").text(roulette.vip[roulette.result]['name']);
                        $("#window-image").css("background", "url(/img/game/" + roulette.vip[roulette.result]['image_key'] + "-WIDE.png) no-repeat center");
                        $("#window-sell-image").css("background", "url(/img/game/" + roulette.vip[roulette.result]['image_key'] + "-WIDE.png) no-repeat center");
                        $("#button-sell").text("Продать за " + roulette.vip[roulette.result]['price_sell'] + "₽");
                        $("#button-take").css("display", "inline-block");
                        if(roulette.vip[roulette.result]['type'] == 3 || roulette.vip[roulette.result]['type'] == 4) {
                            $("#button-sell").text("Забрать выигрыш");
                            $("#button-take").css("display", "none");
                        }
                        $("#game-vip").load(document.URL+" #game-vip>*", function() {
                            roulette.inner = $(".elements-inner");
                            roulette.result = null;
                            roulette.offset = null;
                            $("#game-premium .elements-inner").css('left', '0');
                            $("#roulette-vip").click(function(){
                                roulette.Roulette();
                            });

                            console.info("Рулетка ВИП обновлена");
                        });
                        view.OpenWindow("#window");

                        if( roulette.vip[roulette.result]['type'] == 4 )
                            roulette.KeySell("twokeys");
                        else
                            roulette.KeySell();
                    }
                    else if (roulette.result
                        && roulette.game[roulette.result]['name']
                        && roulette.game[roulette.result]['image_key']
                        && roulette.game[roulette.result]['price_sell'] )
                    {
                        console.info(roulette.result);
                        if ( $(".roulette").hasClass("bonus-roulette"))
                            data.BonusesStop();
                        $("#window-name").text(roulette.game[roulette.result]['name']);
                        $("#window-sell-name").text(roulette.game[roulette.result]['name']);
                        $("#window-image").css("background", "url(/img/game/" + roulette.game[roulette.result]['image_key'] + "-WIDE.png) no-repeat center");
                        $("#window-sell-image").css("background", "url(/img/game/" + roulette.game[roulette.result]['image_key'] + "-WIDE.png) no-repeat center");
                        $("#button-sell").text("Продать за " + roulette.game[roulette.result]['price_sell'] + "₽");
                        $("#button-take").css("display", "inline-block");

                        if(roulette.game[roulette.result]['type'] == 3 || roulette.game[roulette.result]['type'] == 4) {
                            $("#button-sell").text("Забрать выигрыш");
                            $("#button-take").css("display", "none");
                        }

                        view.OpenWindow("#window");
                        //IF BONUS && game[result]['type'] != 4 -> KeySell("bonus");
                        if(roulette.game[roulette.result]['type'] == 4)
                            roulette.KeySell("twokeys");
                        else
                            roulette.KeySell();

                        $("#game").load(document.URL+" #game>*", function()
                        {
                            roulette.inner = $(".elements-inner");
                            roulette.offset = null;
                            roulette.result = null;
                            $("#roulette-premium").click(function(){
                                roulette.Roulette();
                            });
                            console.info("Рулетка обновлена");
                        });
                    }
                    else {
                        $(".arrow").css("display", "inline-block");
                        view.OpenMessageWindow("Упс... Осечка", "Пожалуйста, попробуйте еще раз");
                    }
                }
                else {
                    $(".arrow").css("display", "inline-block");
                    view.OpenMessageWindow("Упс... Осечка", "Пожалуйста, попробуйте еще раз");
                }
            });
        }
        else if(this.RouletteCheck() == "window-misfire") {
            view.OpenMessageWindow("Упс... Осечка", "Пожалуйста, попробуйте еще раз");
        }
        else {
            view.OpenWindow(this.RouletteCheck());
        }
    }
    RouletteCheck()
    {
        if(user.username == undefined)
            return "#window-authorize";
        else if ( $(".roulette").hasClass("bonus-roulette") && user.daily_gift == true )
            return "#window-giftTime";
        else if (user.balance < this.case_price[this.caseOpened])
            return "#window-balance";
        else if (this.roll_offset > 0 && (this.offset == 0 || this.offset == null) && this.roll_speed != 0 && this.result != -1)
            return true;
        else
            return "window-misfire";
    }
    KeySell(code)
    {
        let price;
        let id;
        let type;
        let income;
        let price_sell;
        let caseReal;

        if( this.caseOpened == 0 ) {
            price = roulette.premium[roulette.result]['price'];
            id = roulette.premium[roulette.result]['id'];
            type = roulette.premium[roulette.result]['type'];
            income = roulette.premium[roulette.result]['price_sell'] - roulette.case_price[roulette.caseOpened];
            price_sell = roulette.premium[roulette.result]['price_sell'];
            caseReal = 1;
        }
        else if ( this.caseOpened == 1 )
        {
            price = this.vip[this.result]['price'];
            id = this.vip[this.result]['id'];
            type = this.vip[this.result]['type'];
            income = this.vip[this.result]['price_sell'] - this.case_price[this.caseOpened];
            price_sell = this.vip[this.result]['price_sell'];
            caseReal = 2;
        }
        else
        {
            price = this.game[this.result]['price'];
            id = this.game[this.result]['id'];
            type = this.game[this.result]['type'];
            income = this.game[this.result]['price_sell'] - this.case_price[0];
            price_sell = this.game[this.result]['price_sell'];
            caseReal = this.caseOpened;
        }

        console.info(this.result, price, id, type, income, price_sell, caseReal );
        if ( this.result != -1 || this.result != null || user.id != "" )
            dataRoulette.KeySell(user.id, id, user.balance, price, income, caseReal, this.case_price[this.caseOpened], price_sell, type, code );
    }
    KeySellWindow()
    {
        if(this.caseOpened == 0 && this.premium[this.lastResult]['type'] == 4)
            this.TakeKey("twokeys");
        else if(this.caseOpened == 1 && this.vip[this.lastResult]['type'] == 4)
            this.TakeKey("twokeys");
        else if(this.caseOpened > 1 && this.game[this.lastResult]['type'] == 4)
            this.TakeKey("twokeys");
        else {
            view.OpenMessageWindow("Поздравляем!", "Вам были начислены средства с продажи ключа");
        }
    }

    TakeKey(code)
    {
        let id;
        let price_sell;
        if(this.caseOpened === 0)
        {
            id = this.premium[this.lastResult]['id'];
            price_sell = this.premium[this.lastResult]['price_sell'];
        }
        else if (this.caseOpened === 1)
        {
            id = this.vip[this.lastResult]['id'];
            price_sell = this.vip[this.lastResult]['price_sell']
        }
        else
        {
            id = this.game[this.lastResult]['id'];
            price_sell = this.game[this.lastResult]['price_sell']
        }

        if(this.lastResult != -1 && this.lastResult != null && user.id != "") {
            dataRoulette.TakeKey(id, user.id, user.balance, this.lastIncome, price_sell, this.case_price[this.caseOpened], code);
        }
        else {
            view.OpenMessageWindow("Ошибка", "Пожалуйста, попробуйте позже. Мы автоматически начислили Вам средства с продажи ключа. В случае помощи, обратитесь в техподдержку.");
        }
    }

}

roulette = new Roulette();
roulette.LoadConfigs();

