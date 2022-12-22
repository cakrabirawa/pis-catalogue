Imports System
Imports System.IO
Imports System.Drawing.Imaging
Imports System.IO.File

Public Class Form1

  Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
    Form1_Resize(sender, e)
    With ComboBox1
      For i = 1 To 100
        If (i Mod 5 = 0) Then
          ComboBox1.Items.Add(i)
        End If
      Next
      .SelectedIndex = 0
    End With
  End Sub

  Sub gf_load_dir(ByVal sPath As String)
    On Error Resume Next
    ' Make a reference to a directory.
    Dim di As New DirectoryInfo(sPath)
    Dim i As Long
    i = 0
    ' Get a reference to each file in that directory.
    If (File.GetAttributes(sPath) & FileAttributes.Directory) Then
      Dim fiArr As DirectoryInfo() = di.GetDirectories()
      ' Display the names of the files.
      Dim fri As DirectoryInfo
      progressBar.Maximum = fiArr.Length
      progressBar.Minimum = 0
      progressBar.Value = 0
      For Each fri In fiArr
        'If i = 10 Then Exit Sub
        gf_write_log("Loading Path: " & sPath & fri.Name & "\" & "cover" & "\")
        'gf_load_dir(sPath & fri.Name & "\" & "cover" & "\")
        If txtOuput.Text.Trim = "" Then
          If Not System.IO.Directory.Exists(sPath & fri.Name & "\" & "cover" & "\thumbnail\") Then
            System.IO.Directory.CreateDirectory(sPath & fri.Name & "\" & "cover" & "\thumbnail\")
          End If
        End If
        '---------
        If txtOuput.Text.Trim <> "" Then
          If Not System.IO.Directory.Exists(txtOuput.Text.Trim & Mid(fri.Name, 1, 15)) Then
            System.IO.Directory.CreateDirectory(txtOuput.Text.Trim & Mid(fri.Name, 1, 15))
            System.IO.Directory.CreateDirectory(txtOuput.Text.Trim & Mid(fri.Name, 1, 15) & "\" & "original")
            System.IO.Directory.CreateDirectory(txtOuput.Text.Trim & Mid(fri.Name, 1, 15) & "\" & "thumbnail")
          End If
        End If
        '---------
        progressBar.Value = progressBar.Value + 1
        Me.Refresh()
        gf_load_first_cover_name(sPath & fri.Name & "\" & "cover" & "\", Mid(fri.Name, 1, 15))
        i = i + 1
      Next fri
    End If
    txtInput.Select()
  End Sub

  Sub gf_load_first_cover_name(ByVal sPath As String, sOriginalFileName As String)
    On Error Resume Next
    Dim di As New DirectoryInfo(sPath)
    Dim fiArr As FileInfo() = di.GetFiles()
    Dim fri As FileInfo
    Dim i As Integer
    i = 0
    For Each fri In fiArr
      Dim fi As New IO.FileInfo(sPath & fri.Name)
      If i = 0 And (fi.Extension = ".gif" Or fi.Extension = ".jpeg" Or fi.Extension = ".tiff" Or fi.Extension = ".bmp" Or fi.Extension = ".jpg" Or fi.Extension = ".png") Then
        gf_write_log("Found Cover Name: " & sPath & fri.Name)
        If txtOuput.Text.Trim = "" Then
          If System.IO.File.Exists(sPath & "\" & "cover" & "\thumbnail\" & fri.Name) Then
            System.IO.File.Delete(sPath & "\" & "cover" & "\thumbnail\" & fri.Name)
          End If
          ResizeImage(sPath & fri.Name, 0, 20, sPath & "\thumbnail\" & fri.Name)
          gf_write_log("Resize Iamge [OK]")
        End If
        '--------------------------------
        If txtOuput.Text.Trim <> "" Then
          Copy(sPath & fri.Name, txtOuput.Text.Trim & sOriginalFileName & "\" & "original\" & fri.Name)
          If IsValidImage(sPath & fri.Name) Then
            ResizeImage(sPath & fri.Name, 0, CInt(ComboBox1.Text), txtOuput.Text.Trim & sOriginalFileName & "\" & "thumbnail\" & fri.Name)
          End If
        End If
        '--------------------------------
        i = i + 1
      Else
        Exit Sub
      End If
    Next fri
  End Sub

  Sub gf_write_log(ByVal s As String)
    On Error Resume Next
    richLog.Text = Now() & ": " & s & vbCrLf & richLog.Text
  End Sub

  Public Sub ResizeImage(ByVal ImageSource As String, ByVal ResizeType As Integer, ByVal scale As Single, ByVal ResultPath As String)
    On Error Resume Next
    Dim imgSource As New Bitmap(ImageSource)
    Select Case ResizeType
      Case 0 'percentage
        scale = scale / 100
      Case 1 'width px
        scale = scale / (imgSource.Width)
      Case 2 'height px
        scale = scale / (imgSource.Height)
    End Select
    Dim sclFactor As Single = Single.Parse(scale)
    Dim imgResult As New Bitmap(CInt(imgSource.Width * sclFactor), CInt(imgSource.Height * sclFactor))
    Dim grResult As Graphics = Graphics.FromImage(imgResult)
    grResult.DrawImage(imgSource, 0, 0, imgResult.Width + 1, imgResult.Height + 1)
    If System.IO.File.Exists(ResultPath) Then
      Delete(ResultPath)
    End If
    imgResult.Save(ResultPath, ImageFormat.Jpeg)
  End Sub

  Private Sub cmdStart_Click(sender As Object, e As EventArgs) Handles cmdStart.Click
    On Error Resume Next
    cmdStart.Enabled = False
    gf_load_dir(txtInput.Text.Trim)
    cmdStart.Enabled = True
  End Sub

  Public Function IsValidImage(fileName As String) As Boolean
    Try
      Dim img As Drawing.Image = Nothing
      Dim isValid = False

      Try
        ' Image.FromFile locks the file until the image is disposed.
        ' This might not be the wanted behaviour so it is preferable to
        ' open the file stream and read the image from it.
        Using stream = New System.IO.FileStream(fileName, IO.FileMode.Open)
          img = Drawing.Image.FromStream(stream)
          isValid = True
        End Using

      Catch oome As OutOfMemoryException
        ' Image.FromStream throws an OutOfMemoryException
        ' if the file does not have a valid image format.
        isValid = False

      Finally
        ' clean up resources
        If img IsNot Nothing Then img.Dispose()
      End Try

      Return isValid
    Catch ex As Exception

    End Try
  End Function

  Private Sub Form1_Resize(sender As Object, e As EventArgs) Handles Me.Resize
    richLog.Height = Me.Height - 170
  End Sub

  Private Sub Form1_ResizeEnd(sender As Object, e As EventArgs) Handles Me.ResizeEnd

  End Sub
End Class
