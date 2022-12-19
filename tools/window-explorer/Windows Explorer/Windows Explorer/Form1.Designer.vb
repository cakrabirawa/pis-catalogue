<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Form1
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
    Me.txtInput = New System.Windows.Forms.TextBox()
    Me.richLog = New System.Windows.Forms.RichTextBox()
    Me.cmdStart = New System.Windows.Forms.Button()
    Me.progressBar = New System.Windows.Forms.ProgressBar()
    Me.Label1 = New System.Windows.Forms.Label()
    Me.Label2 = New System.Windows.Forms.Label()
    Me.txtOuput = New System.Windows.Forms.TextBox()
    Me.Label3 = New System.Windows.Forms.Label()
    Me.ComboBox1 = New System.Windows.Forms.ComboBox()
    Me.SuspendLayout()
    '
    'txtInput
    '
    Me.txtInput.Font = New System.Drawing.Font("Tahoma", 8.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
    Me.txtInput.Location = New System.Drawing.Point(177, 12)
    Me.txtInput.Margin = New System.Windows.Forms.Padding(2)
    Me.txtInput.Name = "txtInput"
    Me.txtInput.Size = New System.Drawing.Size(611, 24)
    Me.txtInput.TabIndex = 1
    Me.txtInput.Text = "c:\piselex\prosesprod\"
    '
    'richLog
    '
    Me.richLog.BackColor = System.Drawing.Color.Black
    Me.richLog.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
    Me.richLog.ForeColor = System.Drawing.Color.Red
    Me.richLog.Location = New System.Drawing.Point(11, 152)
    Me.richLog.Margin = New System.Windows.Forms.Padding(2)
    Me.richLog.Name = "richLog"
    Me.richLog.ScrollBars = System.Windows.Forms.RichTextBoxScrollBars.Vertical
    Me.richLog.Size = New System.Drawing.Size(778, 385)
    Me.richLog.TabIndex = 2
    Me.richLog.Text = ""
    '
    'cmdStart
    '
    Me.cmdStart.Location = New System.Drawing.Point(177, 116)
    Me.cmdStart.Margin = New System.Windows.Forms.Padding(2)
    Me.cmdStart.Name = "cmdStart"
    Me.cmdStart.Size = New System.Drawing.Size(111, 32)
    Me.cmdStart.TabIndex = 3
    Me.cmdStart.Text = "Start"
    Me.cmdStart.UseVisualStyleBackColor = True
    '
    'progressBar
    '
    Me.progressBar.Location = New System.Drawing.Point(290, 116)
    Me.progressBar.Margin = New System.Windows.Forms.Padding(2)
    Me.progressBar.Name = "progressBar"
    Me.progressBar.Size = New System.Drawing.Size(496, 32)
    Me.progressBar.TabIndex = 4
    '
    'Label1
    '
    Me.Label1.AutoSize = True
    Me.Label1.Location = New System.Drawing.Point(10, 17)
    Me.Label1.Margin = New System.Windows.Forms.Padding(2, 0, 2, 0)
    Me.Label1.Name = "Label1"
    Me.Label1.Size = New System.Drawing.Size(102, 17)
    Me.Label1.TabIndex = 5
    Me.Label1.Text = "Directory Input"
    '
    'Label2
    '
    Me.Label2.AutoSize = True
    Me.Label2.Location = New System.Drawing.Point(11, 47)
    Me.Label2.Margin = New System.Windows.Forms.Padding(2, 0, 2, 0)
    Me.Label2.Name = "Label2"
    Me.Label2.Size = New System.Drawing.Size(113, 17)
    Me.Label2.TabIndex = 6
    Me.Label2.Text = "Directory Output"
    '
    'txtOuput
    '
    Me.txtOuput.Font = New System.Drawing.Font("Tahoma", 8.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
    Me.txtOuput.Location = New System.Drawing.Point(177, 44)
    Me.txtOuput.Margin = New System.Windows.Forms.Padding(2)
    Me.txtOuput.Name = "txtOuput"
    Me.txtOuput.Size = New System.Drawing.Size(611, 24)
    Me.txtOuput.TabIndex = 7
    '
    'Label3
    '
    Me.Label3.AutoSize = True
    Me.Label3.Location = New System.Drawing.Point(10, 80)
    Me.Label3.Margin = New System.Windows.Forms.Padding(2, 0, 2, 0)
    Me.Label3.Name = "Label3"
    Me.Label3.Size = New System.Drawing.Size(118, 17)
    Me.Label3.TabIndex = 8
    Me.Label3.Text = "Resize Percentage"
    '
    'ComboBox1
    '
    Me.ComboBox1.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList
    Me.ComboBox1.FormattingEnabled = True
    Me.ComboBox1.Location = New System.Drawing.Point(177, 77)
    Me.ComboBox1.Name = "ComboBox1"
    Me.ComboBox1.Size = New System.Drawing.Size(60, 24)
    Me.ComboBox1.TabIndex = 9
    '
    'Form1
    '
    Me.AutoScaleDimensions = New System.Drawing.SizeF(120.0!, 120.0!)
    Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Dpi
    Me.ClientSize = New System.Drawing.Size(797, 549)
    Me.Controls.Add(Me.ComboBox1)
    Me.Controls.Add(Me.Label3)
    Me.Controls.Add(Me.txtOuput)
    Me.Controls.Add(Me.Label2)
    Me.Controls.Add(Me.Label1)
    Me.Controls.Add(Me.progressBar)
    Me.Controls.Add(Me.cmdStart)
    Me.Controls.Add(Me.richLog)
    Me.Controls.Add(Me.txtInput)
    Me.Font = New System.Drawing.Font("Tahoma", 8.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
    Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedSingle
    Me.Margin = New System.Windows.Forms.Padding(2)
    Me.MaximizeBox = False
    Me.Name = "Form1"
    Me.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen
    Me.Text = "Publishers Information System Catalogue Tools"
    Me.ResumeLayout(False)
    Me.PerformLayout()

  End Sub
  Friend WithEvents txtInput As System.Windows.Forms.TextBox
  Friend WithEvents richLog As System.Windows.Forms.RichTextBox
  Friend WithEvents cmdStart As System.Windows.Forms.Button
  Friend WithEvents progressBar As System.Windows.Forms.ProgressBar
  Friend WithEvents Label1 As System.Windows.Forms.Label
  Friend WithEvents Label2 As System.Windows.Forms.Label
  Friend WithEvents txtOuput As System.Windows.Forms.TextBox
  Friend WithEvents Label3 As System.Windows.Forms.Label
  Friend WithEvents ComboBox1 As System.Windows.Forms.ComboBox

End Class
