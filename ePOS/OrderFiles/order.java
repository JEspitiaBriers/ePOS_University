import org.json.*;
import java.nio.file.*;
import java.io.*;
public class JSONCreator {
    public static void CreateOrder(Int orderID, String[] products, float[] cost, float total_cost){
        /*
        rewrite in php
        use array of selected producst
        get prices from databse
        create json heading
        encode array into json
        */

        //connect to database
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:80/epos","root","");
        }
        catch (SQLException sqle) {
            error(sqle);
        }

        //check if order exists
        Statement checkOrder = connection.createStatement();
        ResultSet exists = checkOrder.executeQuery("SELECT * FROM orders WHERE orderID = " + orderID);
        if (!exists.isBeforeFirst()){
            //order does not yet exist so generate new orderID
            Statement highestID = connection.createStatement();
            ResultSet highestResult = highestID.executeQuery("SELECT MAX(orderID) FROM orders");
            highestResult.next() ? orderID = 1 + highestResult.getInt("orderID") : return "Error, max id plus 1 failed";
        }

        orderFile = new FileWriter("/OrderFiles/" + orderID + ".txt", false);

        JSONArray root = new JSONArray();
        root.put("Order Number", "change to orderID variable");

        JSONObject purchase = new JSONObject();

        for(int i=0; i<products.length(); i++){
            //json file will hold the products and their costs
            purchase.add(products[i] + ":" + cost[i]);
        }
        root.put("Products", purchase);
        root.put("Total", total_cost);

        try {
            orderFile.write(root.toJSONString());
        }
        catch (IOException e) {
            e.printStackTrace();
        }
        orderFile.close();
        }
    }
}
