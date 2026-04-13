     AxisDirection.down => targetRect.translate(0.0, offsetDifference),
      AxisDirection.left => targetRect.translate(-offsetDifference, 0.0),
      AxisDirection.right => targetRect.translate(offsetDifference, 0.0),
    };

    return RevealedOffset(offset: targetOffset, rect: targetRect);
  }

  /// The offset at which the given `child` should be painted.
  ///
  /// The returned offset is from the top left corner of the inside of the
  /// viewport to the top left corner of the paint coordinate system of the
  /// `child`.
  ///
  /// See also:
  ///
  ///  * [paintOffsetOf], which uses the layout offset and growth direction
  ///    computed for the child during layout.
  @protected
  Offset computeAbsolutePaintOffset(
    RenderSliver child,
    double layoutOffset,
    GrowthDirection growthDirection,
  ) {
    assert(hasSize); // this is only usable once we have a size
    assert(child.geometry != null);
    return switch (applyGrowthDirectionToAxisDirection(axisDirection, growthDirection)) {
      AxisDirection.up => Offset(0.0, size.height - layoutOffset - child.geometry!.paintExtent),
      AxisDirection.left => Offset(size.width - layoutOffset - child.geometry!.paintExtent, 0.0),
      AxisDirection.right => Offset(layoutOffset, 0.0),
      AxisDirection.down => Offset(0.0, layoutOffset),
    };
  }

  @override
  void debugFillProperties(DiagnosticPropertiesBuilder properties) {
    super.debugFillProperties(properties);
    properties.add(EnumProperty<AxisDirection>('axisDirection', axisDirection));
    properties.add(EnumProperty<AxisDirection>('crossAxisDirection', crossAxisDirection));
    properties.add(DiagnosticsProperty<ViewportOffset>('offset', offset));
  }

  @override
  List<DiagnosticsNo