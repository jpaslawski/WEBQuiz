package pl.jp;

import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.control.*;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.VBox;

public class SignInLayout {

    private Label
            emailLabel = new Label("E-mail"),
            passwordLabel = new Label("Password"),
            sceneLabel = new Label("Sign In");
    private VBox signInBox = new VBox();

    public VBox loadSignInLayout(TextField emailField, PasswordField passwordField, Button singInBtn, Hyperlink linkToSignUp, Label errorLabel) {

        signInBox.setPadding(new Insets(20, 20, 20, 20));
        signInBox.setSpacing(10);

        sceneLabel.setMaxWidth(Double.MAX_VALUE);
        sceneLabel.setStyle("-fx-font-size: 20px;-fx-font-weight: bold;");
        AnchorPane.setLeftAnchor(sceneLabel, 0.0);
        AnchorPane.setRightAnchor(sceneLabel, 0.0);
        sceneLabel.setAlignment(Pos.CENTER);

        emailField.setPromptText("Type the email associated with your account...");
        passwordField.setPromptText("Type your password...");

        singInBtn.setMaxWidth(Double.MAX_VALUE);
        AnchorPane.setLeftAnchor(singInBtn, 0.0);
        AnchorPane.setRightAnchor(singInBtn, 0.0);
        singInBtn.setAlignment(Pos.CENTER);

        signInBox.getChildren().addAll(sceneLabel, emailLabel, emailField, passwordLabel, passwordField, errorLabel, singInBtn, linkToSignUp);

        return signInBox;
    }
}
