package pl.jp;

import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.layout.VBox;
import javafx.stage.Modality;
import javafx.stage.Stage;


public class AlertBox {

    public static void display(String title, String message) {
        Stage window = new Stage();

        window.initModality(Modality.APPLICATION_MODAL);
        window.setTitle(title);
        window.setMinWidth(300);
        window.setMinWidth(200);

        Label label = new Label(message);
        Button closeBtn = new Button("Close");
        closeBtn.setOnAction(e -> window.close());

        VBox vBox = new VBox(10);
        vBox.getChildren().addAll(label, closeBtn);
        vBox.setAlignment((Pos.CENTER));

        Scene scene = new Scene(vBox);
        window.setScene(scene);
        window.showAndWait();
    }
}
