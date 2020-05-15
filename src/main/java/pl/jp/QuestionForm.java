package pl.jp;

import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.control.Button;
import javafx.scene.control.CheckBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.VBox;
import javafx.stage.FileChooser;

public class QuestionForm {
    private Label questionFormLabel = new Label("New Question Form"),
            questionLabel = new Label("Question content");

    private GridPane gridPane = new GridPane();
    private VBox questionFormBox = new VBox();

    public VBox loadQuizFormLayout(TextField questionField, CheckBox answer1, TextField answer1Field, CheckBox answer2,
                                   TextField answer2Field, CheckBox answer3, TextField answer3Field, CheckBox answer4,
                                   TextField answer4Field, Label chosenFile, Button chooseFile, Label errorLabel, Button submitBtn) {
        errorLabel.setText("");

        questionFormBox.setPadding(new Insets(20, 20, 20, 20));
        questionFormBox.setSpacing(10);

        questionFormLabel.setMaxWidth(Double.MAX_VALUE);
        questionFormLabel.setStyle("-fx-font-size: 20px;-fx-font-weight: bold;");
        AnchorPane.setLeftAnchor(questionFormLabel, 0.0);
        AnchorPane.setRightAnchor(questionFormLabel, 0.0);
        questionFormLabel.setAlignment(Pos.CENTER);

        questionField.setPromptText("Type the question here...");

        answer1Field.setPromptText("First answer...");
        answer1Field.setPrefColumnCount(50);
        answer2Field.setPromptText("Second answer...");
        answer2Field.setPrefColumnCount(50);
        answer3Field.setPromptText("Third answer...");
        answer3Field.setPrefColumnCount(50);
        answer4Field.setPromptText("Fourth answer...");
        answer4Field.setPrefColumnCount(50);

        gridPane.add(answer1, 0, 1);
        gridPane.add(answer1Field, 1, 1);
        gridPane.add(answer2, 0, 2);
        gridPane.add(answer2Field, 1, 2);
        gridPane.add(answer3, 0, 3);
        gridPane.add(answer3Field, 1, 3);
        gridPane.add(answer4, 0, 4);
        gridPane.add(answer4Field, 1, 4);

        GridPane gridPane1 = new GridPane();
        chooseFile.setMaxWidth(Double.MAX_VALUE);
        gridPane1.add(chooseFile, 0, 1);
        gridPane1.add(chosenFile, 1, 1);


        submitBtn.setMaxWidth(Double.MAX_VALUE);
        AnchorPane.setLeftAnchor(submitBtn, 0.0);
        AnchorPane.setRightAnchor(submitBtn, 0.0);
        submitBtn.setAlignment(Pos.CENTER);

        questionFormBox.getChildren().addAll(questionFormLabel, questionLabel, questionField, gridPane, gridPane1, errorLabel, submitBtn);

        return questionFormBox;
    }
}
