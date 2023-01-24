class DataUser
{
    GetUserInfo()
    {
        var user;
        $.ajax({
            url: window.location.protocol + "//" + window.location.host +  "/" + "handler/users",
            async:false,
            dataType: "json",
            success: function(data)
            {
                user = data;
            }
        });
        return user;
    }
    GetUsersOnline()
    {
        var result;
        $.ajax({
            url: window.location.protocol + "//" + window.location.host +  "/" + "handler/users/online",
            async: false,
            method: "GET",
            dataType: "text",
            success: function(data) {
                if(!isNaN(data)) {
                    result = data;
                }
            }
        });
        return result;
    }
    GetUserBalance()
    {
        var balance;
        $.ajax({
            url: window.location.protocol + "//" + window.location.host +  "/" + "handler/users/balance",
            async:false,
            method: "GET",
            dataType: "text",
            success: function(data) {
                if(data.indexOf("Баланс: ") !== -1){
                    console.info("[Баланс]: "+ data);
                    balance = data;
                }
                else
                    console.error("[Баланс]: " + data);
            }
        });
        return balance;
    }
}