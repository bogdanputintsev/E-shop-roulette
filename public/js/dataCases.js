class DataCases
{
    GetBasicCasePrice()
    {
        var price;
        $.ajax({
            url: window.location.protocol + "//" + window.location.host +  "/" + "handler/cases/price",
            async:false,
            dataType: "json",
            success: function(data)
            {
                price = data;
            }
        });
        return price;
    }
    GetCasePrice(id)
    {
        var price;
        $.ajax({
            url: window.location.protocol + "//" + window.location.host +  "/" + "handler/cases/price/" + id,
            async:false,
            dataType: "json",
            success: function(data)
            {
                price = data;
            }
        });
        return price;
    }
    GetCaseProducts(id)
    {
        var array;
        $.ajax({
            url: window.location.protocol + "//" + window.location.host +  "/" + "handler/cases/products/" + id,
            async:false,
            dataType: "json",
            success: function(data)
            {
                array = data;
            }
        });
        return array;
    }
}