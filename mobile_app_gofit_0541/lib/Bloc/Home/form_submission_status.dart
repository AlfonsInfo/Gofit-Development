abstract class FormSumbissionStatus{
  const FormSumbissionStatus();
}

class InitialFormStatus extends FormSumbissionStatus{
  const InitialFormStatus();
}

class FormSubmitting extends FormSumbissionStatus{}

class SubmissionSuccess extends FormSumbissionStatus{}


class SubmissionFailed extends FormSumbissionStatus{
  final Exception exception;
  
  SubmissionFailed(this.exception);
}