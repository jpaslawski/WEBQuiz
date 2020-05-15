package pl.jp;

import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.control.*;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.VBox;


public class QuizForm {
    private Label quizFormLabel = new Label("New Quiz Form"),
            nameLabel = new Label("Quiz Name"),
            infoLabel = new Label("Additional information");

    private VBox quizFormBox = new VBox();

    public VBox loadQuizFormLayout(TextField nameField, TextField infoField, Label errorLabel, Button submitBtn) {
        quizFormBox.setPadding(new Insets(20, 20, 20, 20));
        quizFormBox.setSpacing(10);

        quizFormLabel.setMaxWidth(Double.MAX_VALUE);
        quizFormLabel.setStyle("-fx-font-size: 20px;-fx-font-weight: bold;");
        AnchorPane.setLeftAnchor(quizFormLabel, 0.0);
        AnchorPane.setRightAnchor(quizFormLabel, 0.0);
        quizFormLabel.setAlignment(Pos.CENTER);

        nameField.setPromptText("Type the name of the new quiz...");
        infoField.setPromptText("Provide additional information about the quiz...");

        submitBtn.setMaxWidth(Double.MAX_VALUE);
        AnchorPane.setLeftAnchor(submitBtn, 0.0);
        AnchorPane.setRightAnchor(submitBtn, 0.0);
        submitBtn.setAlignment(Pos.CENTER);

        quizFormBox.getChildren().addAll(quizFormLabel, nameLabel, nameField, infoLabel, infoField, errorLabel, submitBtn);

        return quizFormBox;
    }
}
