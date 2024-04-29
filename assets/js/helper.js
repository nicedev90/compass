  const setTime = (string_time) => {
    const options = {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
    };

    let date = new Date(string_time);
    return date.toLocaleDateString('es-ES', options);
  }

  const setDescription = (string) => {
    return string.length > 70 ? string.substring(0,70) + "..." : string+ "...";
  }