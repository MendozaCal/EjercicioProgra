using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Networking;

public class SelectController : MonoBehaviour
{
    private string url = "http://localhost/prographp/Sem13Ejer1.php";

    public void Execute(Action<User[]> callback)
    {
        StartCoroutine(SendRequest(callback));
    }

    private IEnumerator SendRequest(Action<User[]> callback)
    {

        using (UnityWebRequest www = UnityWebRequest.Get(url))
        {
            yield return www.SendWebRequest();

            if (www.result == UnityWebRequest.Result.Success)
            {
                UserModel model = JsonUtility.FromJson<UserModel>(www.downloadHandler.text);
                callback?.Invoke(model.data);
            }
            else
            {
                Debug.Log(www.error);
            }
        }
    }
}