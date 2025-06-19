using System.Collections;
using System.Collections.Generic;
using TMPro;
using UnityEngine;

public class UserView : MonoBehaviour
{
    [SerializeField] private TextMeshProUGUI studentsText;
    private SelectController controller;

    private void Awake()
    {
        controller = GetComponent<SelectController>();
    }

    void Start()
    {
        controller.Execute(OnCallback);
    }

    private void OnCallback(User[] students)
    {
        foreach (User student in students)
        {
            studentsText.text += $"{student.name} - {student.lastname} \n";
        }
    }
}
