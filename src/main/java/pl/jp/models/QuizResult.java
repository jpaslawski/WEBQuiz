package pl.jp.models;

import java.util.*;

public class QuizResult {
    private User user;
    private List<SingleResult> resultList;
    private float percentage;

    public QuizResult() {

    }

    public QuizResult(User user, List<SingleResult> resultList, float percentage) {
        this.user = user;
        this.resultList = resultList;
        this.percentage = percentage;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public List<SingleResult> getResultList() {
        return resultList;
    }

    public void setResultList(List<SingleResult> resultList) {
        this.resultList = resultList;
    }

    public float getPercentage() {
        return percentage;
    }

    public void setPercentage(float percentage) {
        this.percentage = percentage;
    }
}
