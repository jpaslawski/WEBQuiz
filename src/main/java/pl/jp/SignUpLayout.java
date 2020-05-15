package pl.jp;

import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.control.*;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.VBox;

public class SignUpLayout {

    private Label
            firstNameLabel = new Label("First Name"),
            lastNameLabel = new Label("Last Name"),
            emailLabel = new Label("E-mail"),
            passwordLabel = new Label("Password"),
            passwordConfirmLabel = new Label("Confirm Password"),
            sceneLabel = new Label("Sign Up");
    private VBox signUpBox;

    public VBox loadSignUpLayout(TextField firstNameField,
                                 TextField lastNameField,
                                 TextField emailField,
                                 PasswordField passwordField,
                                 PasswordField passwordConfirmField,
                                 Button singInBtn,
                                 Hyperlink linkToSignUp,
                                 Label errorLabel) {
        signUpBox = new VBox();
        signUpBox.setPadding(new Insets(20, 20, 20, 20));
        signUpBox.setSpacing(10);

        sceneLabel.setMaxWidth(Double.MAX_VALUE);
        sceneLabel.setStyle("-fx-font-size: 20px;-fx-font-weight: bold;");
        AnchorPane.setLeftAnchor(sceneLabel, 0.0);
        AnchorPane.setRightAnchor(sceneLabel, 0.0);
        sceneLabel.setAlignment(Pos.CENTER);

        firstNameField.setPromptText("Type your first name...");
        lastNameField.setPromptText("Type your last name...");
        emailField.setPromptText("Type the email associated with your account...");
        passwordField.setPromptText("Type your password...");
        passwordConfirmField.setPromptText("Confirm your password...");

        singInBtn.setMaxWidth(Double.MAX_VALUE);
        AnchorPane.setLeftAnchor(singInBtn, 0.0);
        AnchorPane.setRightAnchor(singInBtn, 0.0);
        singInBtn.setAlignment(Pos.CENTER);

        signUpBox.getChildren().addAll(firstNameLabel, firstNameField,lastNameLabel, lastNameField, emailLabel, emailField, passwordLabel,
                passwordField, passwordConfirmLabel, passwordConfirmField, errorLabel, singInBtn, linkToSignUp);

        return signUpBox;
    }
}
